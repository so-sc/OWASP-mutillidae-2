<?php
	/*  --------------------------------
	 *  We use the session on this page 
	 *  --------------------------------*/
	if (!isset($_SESSION["security-level"])){
		session_start();
	}// end if

	/* ----------------------------------------
	 *	initialize security level to "insecure"
	 * ----------------------------------------*/
	if (!isset($_SESSION['security-level'])){
		$_SESSION['security-level'] = '0';
	}// end if

	/* ------------------------------------------
	 * Constants used in application
	 * ------------------------------------------ */
	require_once('../../includes/constants.php');
	require_once('../../includes/minimum-class-definitions.php');
	
	function populatePOSTSuperGlobal(){
		$lParameters = Array();
		parse_str(file_get_contents('php://input'), $lParameters);
		$_POST = $lParameters + $_POST;
	}// end function populatePOSTArray

	function getPOSTParameter($pParameter, $lRequired){
		if(isset($_POST[$pParameter])){
			return $_POST[$pParameter];
		}else{
			if($lRequired){
				throw new Exception("POST parameter ".$pParameter." is required");
			}else{
				return "";
			}
		}// end if isset
	}// end function validatePOSTParameter

	function jsonEncodeQueryResults($pQueryResult){
		$lDataRows = array();
		while ($lDataRow = mysqli_fetch_assoc($pQueryResult)) {
			$lDataRows[] = $lDataRow;
		}// end while
		
		return json_encode($lDataRows);
	}//end function jsonEncodeQueryResults
	
	try{
		$lAccountUsername = "";
		$lVerb = $_SERVER['REQUEST_METHOD'];
		
		switch($lVerb){
			case "GET":
				if(isset($_GET['username'])){
					/* Example hack: username=jeremy'+union+select+concat('The+password+for+',username,'+is+',+password),mysignature+from+accounts+--+ */
					$lAccountUsername = $_GET['username'];

					if ($lAccountUsername == "*"){
						/* List all accounts */
						$lQueryResult = $SQLQueryHandler->getUsernames();
					}else{
						/* lookup user */
						$lQueryResult = $SQLQueryHandler->getNonSensitiveAccountInformation($lAccountUsername);						
					}// end if
											
					if ($lQueryResult->num_rows > 0){
						echo "Result: {Accounts: {".jsonEncodeQueryResults($lQueryResult)."}}";
					}else{
						echo "Result: {User '".$lAccountUsername."' does not exist}";
					}// end if
					
				}else{

					/* Display help and list accounts */
					echo
						"<br /><br />
						<div><span style='font-weight:bold;'>Help:</span> This service exposes GET, POST, PUT, DELETE methods. This service is vulnerable to SQL injection in security level 0.</div><br />
						<div><span style='font-weight:bold;'>DEFAULT GET:</span> (without any parameters) will display this help plus a list of accounts in the system.</div><br />
						<div><span style='font-weight:bold;'>GET:</span> Either displays usernames of all accounts or the username and signature of one account.<br /><br />Optional params: username AS URL parameter. If username is &quot;*&quot; then all accounts are returned.<br />
						<br />
						Example(s):<br /><br />
							Get a particular user: <a href='http://localhost/mutillidae/webservices/rest/ws-user-account.php?username=adrian'>http://localhost/mutillidae/webservices/rest/ws-user-account.php?username=adrian<br /></a>
							Get all users: <a href='http://localhost/mutillidae/webservices/rest/ws-user-account.php?username=*'>http://localhost/mutillidae/webservices/rest/ws-user-account.php?username=*<br /></a>
							SQL injection: <a href='http://localhost/mutillidae/webservices/rest/ws-user-account.php?username=%6a%65%72%65%6d%79%27%20%75%6e%69%6f%6e%20%73%65%6c%65%63%74%20%63%6f%6e%63%61%74%28%27%54%68%65%20%70%61%73%73%77%6f%72%64%20%66%6f%72%20%27%2c%75%73%65%72%6e%61%6d%65%2c%27%20%69%73%20%27%2c%20%70%61%73%73%77%6f%72%64%29%2c%6d%79%73%69%67%6e%61%74%75%72%65%20%66%72%6f%6d%20%61%63%63%6f%75%6e%74%73%20%2d%2d%20'>http://localhost/mutillidae/webservices/rest/ws-user-account.php?username=jeremy'+union+select+concat('The+password+for+',username,'+is+',+password),mysignature+from+accounts+--+<br /></a>
						</div><br />
						<div><span style='font-weight:bold;'>POST:</span> Creates new account. Required params: username, password AS POST parameter.<br /><br />Optional params: signature AS POST parameter.</div><br />
						<div><span style='font-weight:bold;'>PUT:</span> Creates or updates account. Required params: username, password AS POST parameter.<br /><br />Optional params: signature AS POST parameter.</div><br />
						<div><span style='font-weight:bold;'>DELETE:</span> Deletes account. Required params: username, password AS POST parameter.</div>";
				}// end if

			break;
			case "POST"://create
				
				$lAccountUsername = getPOSTParameter("username", TRUE);
				$lAccountPassword = getPOSTParameter("password", TRUE);
				$lAccountSignature = getPOSTParameter("signature", FALSE);
								
				if ($SQLQueryHandler->accountExists($lAccountUsername)){
					echo "Result: {Account ".$lAccountUsername." already exists}";
				}else{
					$lQueryResult = $SQLQueryHandler->insertNewUserAccount($lAccountUsername, $lAccountPassword, $lAccountSignature);
					echo "Result: {Inserted account ".$lAccountUsername."}";
				}// end if

			break;
			case "PUT":	//create or update
				/* $_POST array is not auto-populated for PUT method. Parse input into an array. */
				populatePOSTSuperGlobal();
				
				$lAccountUsername = getPOSTParameter("username", TRUE);
				$lAccountPassword = getPOSTParameter("password", TRUE);
				$lAccountSignature = getPOSTParameter("signature", FALSE);
								
				if ($SQLQueryHandler->accountExists($lAccountUsername)){
					$lQueryResult = $SQLQueryHandler->updateUserAccount($lAccountUsername, $lAccountPassword, $lAccountSignature);
					echo "Result: {Updated account ".$lAccountUsername.". ".$lQueryResult." rows affected.}";
				}else{
					$lQueryResult = $SQLQueryHandler->insertNewUserAccount($lAccountUsername, $lAccountPassword, $lAccountSignature);
					echo "Result: {Inserted account ".$lAccountUsername.". ".$lQueryResult." rows affected.}";
				}// end if
				
			break;
			case "DELETE":
				/* $_POST array is not auto-populated for DELETE method. Parse input into an array. */
				populatePOSTSuperGlobal();
								
				$lAccountUsername = getPOSTParameter("username", TRUE);
				$lAccountPassword = getPOSTParameter("password", TRUE);

				if($SQLQueryHandler->accountExists($lAccountUsername)){

					if($SQLQueryHandler->authenticateAccount($lAccountUsername,$lAccountPassword)){
						$lQueryResult = $SQLQueryHandler->deleteUser($lAccountUsername);
					
						if ($lQueryResult){
							echo "Result: {Deleted account ".$lAccountUsername."}";
						}else{
							echo "Result: {Attempted to delete account ".$lAccountUsername." but result returned was ".$lQueryResult."}";
						}//end if
						
					}else{
						echo "Result: {Could not authenticate account ".$lAccountUsername.". Password incorrect.}";
					}// end if

				}else{
					echo "Result: {User '".$lAccountUsername."' does not exist}";
				}// end if
				
			break;
			default:
				throw new Exception("Could not understand HTTP REQUEST_METHOD verb");
			break;
		}// end switch

	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatErrorJSON($e, "Unable to process request to web service ws-user-account");
	}// end try;
	
?>