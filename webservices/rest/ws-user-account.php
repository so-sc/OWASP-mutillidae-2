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
					/* Example hack: username=adrian'+union+select+username,+password+AS+password+from+accounts+--+ */
					$lAccountUsername = $_GET['username'];

					$lQueryResult = $SQLQueryHandler->getNonSensitiveAccountInformation($lAccountUsername);
					
					if ($lQueryResult->num_rows > 0){
						echo "Result: {Accounts: {".jsonEncodeQueryResults($lQueryResult)."}}";
					}else{
						echo "Result: {User '".$lAccountUsername."' does not exist}";
					}// end if
					
					/*
					if (!$SQLQueryHandler->accountExists($lAccountUsername)){
						echo "Result: {User '".$lAccountUsername."' does not exist}";
					}else{	
						$lQueryResult = $SQLQueryHandler->getNonSensitiveAccountInformation($lAccountUsername);
						echo "Result: {Accounts: {".jsonEncodeQueryResults($lQueryResult)."}}";
					}// end if accountExists
					*/
				}else{
					/* List all accounts */
					$lQueryResult = $SQLQueryHandler->getUsernames();

					echo
						"<br /><br />
						<div><span style='font-weight:bold;'>Help:</span> This service exposes GET, POST, PUT, DELETE methods.</div><br />
						<div><span style='font-weight:bold;'>DEFAULT GET:</span> (without any parameters) will display this help plus a list of accounts in the system.<br /><br />
						This service is vulnerable to SQL injection in security level 0.</div><br />
						<div><span style='font-weight:bold;'>GET:</span> Either displays usernames of all accounts or the username and signature of one account.<br /><br />Optional params: username AS URL parameter.</div><br />
						<div><span style='font-weight:bold;'>POST:</span> Creates new account. Required params: username, password AS POST parameter.<br /><br />Optional params: signature AS POST parameter.</div><br />
						<div><span style='font-weight:bold;'>PUT:</span> Creates or updates account. Required params: username, password AS POST parameter.<br /><br />Optional params: signature AS POST parameter.</div><br />
						<div><span style='font-weight:bold;'>DELETE:</span> Deletes account. Required params: username, password AS POST parameter.</div><br />
						<br />
						Result: {
							Accounts: {".jsonEncodeQueryResults($lQueryResult)."}
						}";
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

				if (!$SQLQueryHandler->accountExists($lAccountUsername)){
					echo "Result: {User '".$lAccountUsername."' does not exist}";
				}elseif ($SQLQueryHandler->authenticateAccount($lAccountUsername,$lAccountPassword)){
					$lQueryResult = $SQLQueryHandler->deleteUser($lAccountUsername);
				
					if ($lQueryResult){
						echo "Result: {Deleted account ".$lAccountUsername."}";
					}else{
						echo "Result: {Attempted to delete account ".$lAccountUsername." but result returned was ".$lQueryResult."}";
					}//end if
				}else{
					echo "Result: {Could not authenticate account ".$lAccountUsername.". Password incorrect.}";
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