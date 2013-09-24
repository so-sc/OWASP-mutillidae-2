<?php
    try {
		$lQueryString = "";
    	switch ($_SESSION["security-level"]){
	   		case "0": // This code is insecure
	   		case "1": // This code is insecure
				/*
				 * Grab username and password from parameters. 
				 * Notice in insecure mode, we take parameters from "REQUEST" which
				 * could be GET OR POST. This is not correct. The page
				 * intends to receive parameters from POST and should
				 * restrict parameters to POST only.
				 */ 
				$lUsername = $_REQUEST["username"];
				$lPassword = $_REQUEST["password"];	   			
	   			$lProtectCookies = FALSE;
	   		break;
		    		
			case "2":
			case "3":
			case "4":
	   		case "5": // This code is fairly secure
	   			/* Restrict paramters to POST */
				$lUsername = $_POST["username"];
				$lPassword = $_POST["password"];
	   			$lProtectCookies = TRUE;
	   		break;
	   	}// end switch

	   	try {
	   		$LogHandler->writeToLog("Attempt to log in by user: " . $lUsername);	
	   	} catch (Exception $e) {
	   		//do nothing
	   	}// end try

	   	$lQueryResult = $SQLQueryHandler->getAccount($lUsername, $lPassword);
	    if ($lQueryResult->num_rows > 0) {
		    $row = $lQueryResult->fetch_object();
			$failedloginflag=0;
			$_SESSION['loggedin'] = 'True';
			$_SESSION['uid'] = $row->cid;
			$_SESSION['logged_in_user'] = $row->username;
			$_SESSION['logged_in_usersignature'] = $row->mysignature;
			$_SESSION['is_admin'] = $row->is_admin;

			/*
			/* Set client-side auth token. if we are in insecure mode, we will
			 * pay attention to client-side authorization tokens. If we are secure,
			 * we dont use client-side authortization tokens and we ignore any
			 * attempts to use them.
			 * 
			 * If in secure mode, we want the cookie to be protected
			 * with HTTPOnly flag. There is some irony here. In secure code,
			 * we are to ignore authorization cookies, so we are protecting
			 * a cookie we know we are going to ignore. But the point is to
			 * provide an example to developers of proper coding techniques.
			 * 
			 * Note: Ideally this cookie must be protected with SSL also but
			 * again this is just a demo. Once your in SSL mode, maintain SSL
			 * and escalate any requests for HTTP to HTTPS.
			 */
			if ($lProtectCookies){
				$lUsernameCookie = $Encoder->encodeForURL($row->username);
				setcookie("username", $lUsernameCookie, 0, "", "", FALSE, TRUE);
				setcookie("uid", $row->cid, 0, "", "", FALSE, TRUE);
			}else {
				//setrawcookie() allows for response splitting
				$lUsernameCookie = $row->username;
				setrawcookie("username", $lUsernameCookie);
				setrawcookie("uid", $row->cid);
			}// end if
			
		   	try {
				$LogHandler->writeToLog("Logged in user: " . $row->username . " (" . $row->cid . ")");
		   	} catch (Exception $e) {
		   		//do nothing
		   	}// end try
			
		   	/* Redirect back to the home page */
			header('Location: index.php?popUpNotificationCode=AU1', true, 302);
		} else {
			try{
				$LogHandler->writeToLog("Failed login attempt for user: " . $lUsername);
		   	} catch (Exception $e) {
		   		//do nothing
		   	}// end try
			$failedloginflag=1;
    	}// end if ($lQueryResult->num_rows > 0)
	    
	} catch (Exception $e) {
		try{
			$LogHandler->writeToLog("Failed login attempt for user: " . $lUsername);
	   	} catch (Exception $e) {
	   		//do nothing
	   	}// end try
		$failedloginflag=1;
		echo $CustomErrorHandler->FormatErrorJSON($e, "Failed login attempt");
	}// end try
?>