<div class="page-title">Register for an Account</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-wrapper.inc'); ?>

<?php
	switch ($_SESSION["security-level"]){
		case "0": // This code is insecure
			// DO NOTHING: This is equivalent to using client side security
			$lProtectAgainstMethodTampering = FALSE;
			$lEncodeOutput = FALSE;
			$lProtectAgainstCSRF = FALSE;
			$lCSRFTokenStrength = "NONE";
		break;
	
		case "1": // This code is insecure
			// DO NOTHING: This is equivalent to using client side security
			$lProtectAgainstMethodTampering = FALSE;
			$lEncodeOutput = FALSE;
			$lProtectAgainstCSRF = TRUE;
			$lCSRFTokenStrength = "LOW";
		break;
			 
		case "2":
		case "3":
		case "4":
		case "5": // This code is fairly secure
			/*
			 * Concerning SQL Injection, use parameterized stored procedures. Parameterized
			 * queries is not good enough. You cannot use least privilege with queries.
			 */
			$lProtectAgainstMethodTampering = TRUE;
			$lEncodeOutput = TRUE;
			$lProtectAgainstCSRF = TRUE;
			$lCSRFTokenStrength = "HIGH";
		break;
	}// end switch

	$lNewCSRFTokenForNextRequest = "CSRFProtectionDisabled";
	$lExpectedTokenForThisRequest = "";
	if($lProtectAgainstCSRF){
		/* Record the CSRF token that we saved in the session when we offered the ADD BLOG
		 * page to the user. This was the token we created before the user POSTed to this page
		* a new blog entry to be saved.
		*/
		$lPostedCSRFToken = "";
		 
		if (isset($_SESSION['register-user']['csrf-token'])){
			$lExpectedTokenForThisRequest = $_SESSION['register-user']['csrf-token'];
		}//end if
		 
		/* Store a new token in the session for the NEXT request to add a new blog entry.
		* The user might be making a request right now, but this token is for the next
		* request if it ever occurs.
		*/
		switch ($lCSRFTokenStrength){
			case "HIGH":
				$_SESSION['register-user']['csrf-token'] = $lNewCSRFTokenForNextRequest = $ESAPIRandomizer->getRandomString(32, "ABCDEFGEHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890");
			break;
			case "MEDIUM":
				$_SESSION['register-user']['csrf-token'] = $lNewCSRFTokenForNextRequest = mt_rand();
			break;
			case "LOW":
				if (!is_null($lExpectedTokenForThisRequest)) {
					$_SESSION['register-user']['csrf-token'] = $lNewCSRFTokenForNextRequest = ($lExpectedTokenForThisRequest + 7777);
				}else{
				//initialize the tokens
					$_SESSION['register-user']['csrf-token'] = $lNewCSRFTokenForNextRequest = 5323;
				}//end if
			break;
			default:break;
		}//end switch on $lCSRFTokenStrength
	
		/* Record the token which the user just passed in. If they used the page offered, the token
		* should match. If the users browser was forced to make a request, the token sent should
		* not match unless the attacker makes a good guess.
		*/
		if (isset($_POST['csrf-token'])){
			$lPostedCSRFToken = $_POST['csrf-token'];
		}//end if
		
	}// end if $lProtectAgainstCSRF
	
	if (isset($_REQUEST["register-php-submit-button"])){
		
		try {					
			$lValidationFailed = false;			
		   	
	   		if ($lProtectAgainstMethodTampering) {
   				$lUsername = $_POST["username"];
				$lPassword = $_POST["password"];
				$lConfirmedPassword = $_POST["confirm_password"];
				$lUserSignature = $_POST["my_signature"];
	   		}else{
	   			$lUsername = $_REQUEST["username"];
				$lPassword = $_REQUEST["password"];
				$lConfirmedPassword = $_REQUEST["confirm_password"];
				$lUserSignature = $_REQUEST["my_signature"];
	   		}//end if
	   		
	   		if ($lEncodeOutput){
	   			$lUsernameText = $Encoder->encodeForHTML($lUsername);
	   		}else{
	   			//allow XSS by not encoding
	   			$lUsernameText = $lUsername;
	   		}//end if
	   		
			$LogHandler->writeToLog("Attempting to add account for: " . $lUsername);				
		   	
		   	if (strlen($lUsername) == 0) {
		   		$lValidationFailed = true;
				echo '<h2 class="error-message">Username cannot be blank</h2>';
		   	}// end if
					
		   	if ($lPassword != $lConfirmedPassword ) {
				$lValidationFailed = true;
		   		echo '<h2 class="error-message">Passwords do not match</h2>';
		   	}// end if
				
			if ($lProtectAgainstCSRF){
				if ($lPostedCSRFToken != $lExpectedTokenForThisRequest){
					throw (new Exception("Security Violation: Cross Site Request Forgery attempt detected.", 500));
				}// end if
			}// end if
		   	
		   	if (!$lValidationFailed){					
		   		$lRowsAffected = $SQLQueryHandler->insertNewUserAccount($lUsername, $lPassword, $lConfirmedPassword);
				echo '<h2 class="success-message">Account created for ' . $lUsernameText .'. '.$lRowsAffected.' rows inserted.</h2>';
				$LogHandler->writeToLog("Added account for: " . $lUsername);
		   	}// end if (!$lValidationFailed)
			
		} catch (Exception $e) {
			echo $CustomErrorHandler->FormatError($e, "Failed to add account");
			$LogHandler->writeToLog("Failed to add account for: " . $lUsername);			
		}// end try
			
	}// end if (isset($_POST["register-php-submit-button"])){
?>

<!-- Bubble hints code -->
<?php 
	try{
   		$lHTMLandXSSandSQLInjectionPointBalloonTip = $BubbleHintHandler->getHint("HTMLandXSSandSQLInjectionPoint");
   		$lSQLInjectionPointBallonTip = $BubbleHintHandler->getHint("SQLInjectionPoint");
   		
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try
?>

<script type="text/javascript">
	$(function() {
		$('[HTMLandXSSandSQLInjectionPoint]').attr("title", "<?php echo $lHTMLandXSSandSQLInjectionPointBalloonTip; ?>");
		$('[HTMLandXSSandSQLInjectionPoint]').balloon();
		$('[SQLInjectionPoint]').attr("title", "<?php echo $lSQLInjectionPointBallonTip; ?>");
		$('[SQLInjectionPoint]').balloon();	
	});
</script>

<div id="id-registration-form-div">
	<form action="index.php?page=register.php" method="post" enctype="application/x-www-form-urlencoded">
		<input name="csrf-token" type="hidden" value="<?php echo $lNewCSRFTokenForNextRequest; ?>" />
		<table style="margin-left:auto; margin-right:auto;">
			<tr id="id-bad-cred-tr" style="display: none;">
				<td colspan="2" class="error-message">
					Authentication Error: Bad user name or password
				</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td colspan="2" class="form-header">Please choose your username, password and signature</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="label">Username</td>
				<td><input HTMLandXSSandSQLInjectionPoint="1" type="text" name="username" size="20"></td>
			</tr>
			<tr>
				<td class="label">Password</td>
				<td><input SQLInjectionPoint="1" type="password" name="password" size="20"></td>
			</tr>
			<tr>
				<td class="label">Confirm Password</td>
				<td><input SQLInjectionPoint="1" type="password" name="confirm_password" size="20"></td>
			</tr>
			<tr>
				<td class="label">Signature</td>
				<td><textarea HTMLandXSSandSQLInjectionPoint="1" rows="10" cols="50" name="my_signature"></textarea></td>
			</tr>			
			<tr><td></td></tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input name="register-php-submit-button" class="button" type="submit" value="Create Account" />
				</td>
			</tr>
			<tr><td></td></tr>
		</table>
	</form>
</div>

<?php
	if ($lProtectAgainstCSRF){
		echo('<div>&nbsp;</div>'.PHP_EOL);
		echo('<div>&nbsp;</div>'.PHP_EOL);
		echo('<fieldset>'.PHP_EOL);
		echo('<legend>CSRF Protection Information</legend>'.PHP_EOL);
		echo('<table style="margin-left:auto; margin-right:auto;">'.PHP_EOL);
		echo('<tr><td></td></tr>'.PHP_EOL);
		echo('<tr><td class="report-header">Posted Token: '.$lPostedCSRFToken.'</td></tr>'.PHP_EOL);
		echo('<tr><td>Expected Token For This Request: '.$lExpectedTokenForThisRequest.'</td></tr>'.PHP_EOL);
		echo('<tr><td>Token Passed By User For This Request: '.$lPostedCSRFToken.'</td></tr>'.PHP_EOL);
		echo('<tr><td>&nbsp;</td></tr>'.PHP_EOL);
		echo('<tr><td>New Token For Next Request: '.$lNewCSRFTokenForNextRequest.'</td></tr>'.PHP_EOL);
		echo('<tr><td>Token Stored in Session: '.$_SESSION['register-user']['csrf-token'].'</td></tr>'.PHP_EOL);
		echo('<tr><td></td></tr>'.PHP_EOL);
		echo('</table>'.PHP_EOL);
		echo('</fieldset>'.PHP_EOL);
	}// end if $lProtectAgainstCSRF

	if ($_SESSION["showhints"] == 2) {
		include_once './includes/hints-level-2/sql-injection-tutorial.inc';
		include_once '/includes/hints-level-2/cross-site-scripting-tutorial.inc';
		include_once '/includes/hints-level-2/cross-site-request-forgery-tutorial.inc';
	}// end if
?>