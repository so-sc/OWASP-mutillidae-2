<?php
   	// Pull in the NuSOAP code
	require_once('./lib/nusoap.php');
	
	// Create the server instance
	$lSOAPWebService = new soap_server();
	
	// Initialize WSDL support
	$lSOAPWebService->configureWSDL('sqliwsdl', 'urn:sqliwsdl');
	
	// Register the method to expose
	$lSOAPWebService->register('getUserInformation',                	// method name
	    array('username' => 'xsd:string','password' => 'xsd:string'),	// input parameters
	    array('return' => 'xsd:xml'),      								// output parameters
	    'urn:sqliwsdl',                      							// namespace
	    'urn:sqliwsdl#sqli',                							// soapaction
	    'rpc',                                							// style
	    'encoded',                            							// use
	    'Fetches user information is username and password are correct'	// documentation
	);

	// Define the method as a PHP function
	function getUserInformation($pUsername, $pPassword) {

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
			echo $CustomErrorHandler->FormatError($e, "Unable to parse session");
	   	}// end try;
		
		$lResults = "";
	    $lResultsFound = FALSE;
	    $lKeepGoing = TRUE;
	    $lQueryResult=NULL;
	    
		try{
			
		   	if (!$SQLQueryHandler->accountExists($pUsername)){
		   		$lResults = "<message>Account {$pUsername} does not exist</message>";	 
		   		$lKeepGoing = FALSE;
		   	}// end if accountExists
		   			   	
		   	if ($lKeepGoing){
			   	if (!$SQLQueryHandler->authenticateAccount($pUsername, $pPassword)){
			   		$lResults = "<message>Incorrect password</message>";
			   		$lKeepGoing = FALSE;
			   	}//end if authenticateAccount
			}//end if $lKeepGoing
		   					
			if ($lKeepGoing){
				$lQueryResult = $SQLQueryHandler->getUserAccount($pUsername, $pPassword);

				if (isset($lQueryResult->num_rows)){
					if ($lQueryResult->num_rows > 0) {
						$lResultsFound = TRUE;
					}//end if
				}//end if

				if(!$lResultsFound){
					$lResults = '<message>No Results Found</message>';
					$lKeepGoing = FALSE;
				}// end if
			}//end if $lKeepGoing

			/* Print out results */
			if ($lKeepGoing){
				$lResults = "<accounts>";
			
				while($row = $lQueryResult->fetch_object()){
					try {
						$LogHandler->writeToLog("ws-lookup-user-information.php: Fetched user-information for: " . $row->username);
					} catch (Exception $e) {
						// do nothing
					}//end try
			
					if(!$lEncodeOutput){
						$lUsername = $row->username;
						$lPassword = $row->password;
						$lSignature = $row->mysignature;
					}else{
						$lUsername = $Encoder->encodeForHTML($row->username);
						$lPassword = $Encoder->encodeForHTML($row->password);
						$lSignature = $Encoder->encodeForHTML($row->mysignature);
					}// end if
			
					$lResults.= "<account>";
					$lResults.= "<username>{$lUsername}</username>";
					$lResults.= "<password>{$lPassword}</password>";
					$lResults.= "<signature>{$lSignature}</signature>";
					$lResults.= "</account>";
				}// end while
			
				$lResults.= "</accounts>";
			}// end if ($lResultsFound)
					
	    } catch (Exception $e) {
			echo $CustomErrorHandler->FormatError($e, "Error querying user account");
	    }// end try;
	    
	    return $lResults;
	    
	}// end function
	
	// Use the request to (try to) invoke the service
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$lSOAPWebService->service($HTTP_RAW_POST_DATA);
?>
