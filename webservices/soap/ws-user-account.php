<?php
	/* Example SQL injection: jeremy' union select username,password from accounts -- */ 

	/* We use the session on this page */
	if (!isset($_SESSION["security-level"])){
		session_start();
	}// end if
	
	// ----------------------------------------
	// initialize security level to "insecure"
	// ----------------------------------------
	if (!isset($_SESSION['security-level'])){
		$_SESSION['security-level'] = '0';
	}// end if
	
	/* ------------------------------------------
	 * Constants used in application
	* ------------------------------------------ */
	require_once('../../includes/constants.php');
	require_once('../../includes/minimum-class-definitions.php');
	 
	try{
		switch ($_SESSION["security-level"]){
			case "0": // This code is insecure
			case "1": // This code is insecure
				$lEncodeOutput = FALSE;
				break;
	
			case "2":
			case "3":
			case "4":
			case "5": // This code is fairly secure
				$lEncodeOutput = TRUE;
				break;
		}//end switch
	
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "ws-user-account.php: Unable to parse session");
	}// end try;

	// Pull in the NuSOAP code
	require_once('./lib/nusoap.php');
	
	// Create the server instance
	$lSOAPWebService = new soap_server();
	
	// Initialize WSDL support
	$lSOAPWebService->configureWSDL('ws-user-account', 'urn:ws-user-account');
	
	// Register the method to expose
	$lSOAPWebService->register('getUser',			                	// method name
	    array('username' => 'xsd:string'),								// input parameters
	    array('return' => 'xsd:xml'),      								// output parameters
	    'urn:ws-user-account',                      					// namespace
	    'urn:ws-user-account#getUser',                					// soapaction
	    'rpc',                                							// style
	    'encoded',                            							// use
	    'Fetches user information is user exists else returns message'	// documentation
	);

	// Register the method to expose
	$lSOAPWebService->register('createUser',			                	// method name
			array(
				'username' => 'xsd:string',
				'password' => 'xsd:string',
				'signature' => 'xsd:string'
			),																// input parameters
			array('return' => 'xsd:xml'),      								// output parameters
			'urn:ws-user-account',                      					// namespace
			'urn:ws-user-account#createUser',                				// soapaction
			'rpc',                                							// style
			'encoded',                            							// use
			'Creates new user account'										// documentation
	);
	
	function doXMLEncodeQueryResults($pUsername, $pQueryResult, $pEncodeOutput){

		$lResults = "<accounts message=\"Results for {$pUsername}\">";
		$lUsername = "";
		$lSignature = "";
		
		while($row = $pQueryResult->fetch_object()){
				
			if(!$pEncodeOutput){
				$lUsername = $row->username;
			}else{
				$lUsername = $Encoder->encodeForHTML($row->username);
			}// end if

			if(isset($row->mysignature)){
				if(!$pEncodeOutput){
					$lSignature = $row->mysignature;
				}else{
					$lSignature = $Encoder->encodeForHTML($row->mysignature);
				}// end if
			}// end if					
			
			$lResults.= "<account>";
			$lResults.= "<username>{$lUsername}</username>";
			if(isset($row->mysignature)){$lResults.= "<signature>{$lSignature}</signature>";};
			$lResults.= "</account>";

		}// end while
			
		$lResults.= "</accounts>";
		
		return $lResults;
		
	}//end function doXMLEncodeQueryResults
	
	function xmlEncodeQueryResults($pUsername, $pEncodeOutput, $SQLQueryHandler){

		$lQueryResult = "";
		
		if ($pUsername == "*"){
			/* List all accounts */
			$lQueryResult = $SQLQueryHandler->getUsernames();
		}else{
			/* lookup user */
			$lQueryResult = $SQLQueryHandler->getNonSensitiveAccountInformation($pUsername);
		}// end if
		
		if ($lQueryResult->num_rows > 0){
			return doXMLEncodeQueryResults($pUsername, $lQueryResult, $pEncodeOutput);
		}else{
			return "<accounts message=\"User {$pUsername} does not exist}\" />";
		}// end if
		
	}// end function xmlEncodeQueryResults()

	// Define the method as a PHP function
	function getUser($pUsername) {

		try{
		   	$lResults = "";
		   	global $LogHandler;
		   	global $lEncodeOutput;
		   	global $SQLQueryHandler;	   	
		   	global $CustomErrorHandler;
		   	
			try {
				$LogHandler->writeToLog("ws-user-account.php: Fetched user-information for: {$pUsername}");
			} catch (Exception $e) {
				// do nothing
			}//end try
						
			$lResults = xmlEncodeQueryResults($pUsername, $lEncodeOutput, $SQLQueryHandler);
									
		    return $lResults;

	    } catch (Exception $e) {
	    	return $CustomErrorHandler->FormatErrorXML($e, "Unable to process request to web service ws-user-account->getUser()");
	    }// end try
		    
	}// end function getUser()
	
	function assertParameter($pParameter){
		if(strlen($pParameter) == 0 || !isset($pParameter)){
			throw new Exception("Parameter ".$pParameter." is required");
		}// end if
	}// end function assertParameter
	
	function createUser($pUsername, $pPassword, $pSignature){
		
		try{
			
			global $LogHandler;
			global $lEncodeOutput;
			global $SQLQueryHandler;
			global $CustomErrorHandler;
			
			assertParameter($pUsername);
			assertParameter($pPassword);
			assertParameter($pSignature);
			
			if ($SQLQueryHandler->accountExists($pUsername)){
				return "<accounts message=\"User {$pUsername} already exists\" />";
			}else{
				$lQueryResult = $SQLQueryHandler->insertNewUserAccount($pUsername, $pPassword, $pSignature);
				return "<accounts message=\"Inserted account {$pUsername}\" />";
			}// end if
		
		} catch (Exception $e) {
			return $CustomErrorHandler->FormatErrorXML($e, "Unable to process request to web service ws-user-account->createUser()");
		}// end try
		
	}// end function createUser()
			
	// Use the request to (try to) invoke the service
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$lSOAPWebService->service($HTTP_RAW_POST_DATA);
?>
