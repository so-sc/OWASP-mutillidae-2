
<?php
	/* Known Vulnerabilities: 
		Cross Site Scripting, 
		Cross Site Request Forgery,
		Application Exception Output,
		HTML injection,
		HTTP Parameter Pollution
	*/

	require_once (__ROOT__.'/classes/CSRFTokenHandler.php');
	$lCSRFTokenHandler = new CSRFTokenHandler("owasp-esapi-php/src/", $_SESSION["security-level"], "register-user");

	switch ($_SESSION["security-level"]){
   		case "0": // This code is insecure
   			$lEnableHTMLControls = FALSE;
   			$lEncodeOutput = FALSE;
   			$lProtectAgainstMethodTampering = FALSE;
   			$lHTTPParameterPollutionDetected = FALSE;
   		break;
   			   			
   		case "1": // This code is insecure
   			// DO NOTHING: This is insecure		
			$lEnableHTMLControls = TRUE;
   			$lEncodeOutput = FALSE;
			$lProtectAgainstMethodTampering = FALSE;
			$lHTTPParameterPollutionDetected = FALSE;
		break;
	    		
		case "2":
		case "3":
		case "4":
		case "5": // This code is fairly secure
			$lEnableHTMLControls = TRUE;
				
			/* 
  			 * NOTE: Input validation is excellent but not enough. The output must be
  			 * encoded per context. For example, if output is placed in HTML,
  			 * then HTML encode it. Blacklisting is a losing proposition. You 
  			 * cannot blacklist everything. The business requirements will usually
  			 * require allowing dangerous charaters. In the example here, we can 
  			 * validate username but we have to allow special characters in passwords
  			 * least we force weak passwords. We cannot validate the signature hardly 
  			 * at all. The business requirements for text fields will demand most
  			 * characters. Output encoding is the answer. Validate what you can, encode it
  			 * all.
  			 */
   			// encode the output following OWASP standards
   			// this will be HTML encoding because we are outputting data into HTML
			$lEncodeOutput = TRUE;
			$lProtectAgainstMethodTampering = TRUE;
			
			// Detect multiple params with same name (HTTP Parameter Pollution)
			$lQueryString  = explode('&', $_SERVER['QUERY_STRING']);
			$lKeys = array();
			$lPair = array();
			$lParameter = "";
			
			foreach ($lQueryString as $lParameter){
				$lPair = explode('=', $lParameter);
				array_push($lKeys, $lPair[0]);
			}//end for each

			$lCountUnique = count(array_unique($lKeys));
			$lCountTotal = count($lKeys);
			
			$lHTTPParameterPollutionDetected = ($lCountUnique < $lCountTotal);
			
   		break;
   	}// end switch		

   	if ($lEnableHTMLControls) {
   		$lHTMLControlAttributes='required="true"';
   	}else{
   		$lHTMLControlAttributes="";
   	}// end if
   	   	
   	$lNewCSRFTokenForNextRequest = $lCSRFTokenHandler->generateCSRFToken();
   	   	
   	// initialize message
   	$lUserChoiceMessage = "No choice selected";
   	$lUserInitials ="";

   	// determine if user clicked the submit buttton
   	if(!$lProtectAgainstMethodTampering){
   		$lFormSubmitted = isSet($_REQUEST["user-poll-php-submit-button"]);
   	}else{
   		$lFormSubmitted = isSet($_GET["user-poll-php-submit-button"]);
   	}//end if   

   	// if user clicked submit button, process input parameters
   	if($lFormSubmitted){
   		try{
	   		// if we want to enforce GET method, we need to be careful to specify $_GET
		   	if(!$lProtectAgainstMethodTampering){
		   		$lUserChoice = $_REQUEST["choice"];
		   		$lUserInitials = $_REQUEST["initials"];
				$lPostedCSRFToken = $_REQUEST["csrf-token"];
		   	}else{
		   		$lUserChoice = $_GET["choice"];
		   		$lUserInitials = $_GET["initials"];
		   		$lPostedCSRFToken = $_GET["csrf-token"];
		   	}//end if
	
		   	if (!$lCSRFTokenHandler->validateCSRFToken($lPostedCSRFToken)){
		   		throw (new Exception("Security Violation: Cross Site Request Forgery attempt detected.", 500));
		   	}// end if
		   		  
		   	// Encode output to protect against cross site scripting 
			if ($lEncodeOutput){
				$lUserInitials = $Encoder->encodeForHTML($lUserInitials);
				$lUserChoice = $Encoder->encodeForHTML($lUserChoice);
			}// end if
	
			// if parameter pollution is not detected, print user choice 
		   	if (!$lHTTPParameterPollutionDetected){
				$lUserChoiceMessage = "Your choice was {$lUserChoice}";
				$LogHandler->writeToLog("User voted for: " . $lUserChoice);
		   	}// end if isSet($_POST["user-poll-php-submit-button"])
	   	
	   	} catch (Exception $e) {
	   		echo $CustomErrorHandler->FormatError($e, "Vote was not counted");
	   	}// end try
	   		  
   	}//end if lFormSubmitted

?>

<!-- Bubble hints code -->
<?php 
	try{
   		$lReflectedXSSExecutionPointBallonTip = $BubbleHintHandler->getHint("ReflectedXSSExecutionPoint");
   		$lParameterPollutionInjectionPointBallonTip = $BubbleHintHandler->getHint("ParameterPollutionInjectionPoint");
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try
?>

<script type="text/javascript">
	$(function() {
		$('[ReflectedXSSExecutionPoint]').attr("title", "<?php echo $lReflectedXSSExecutionPointBallonTip; ?>");
		$('[ReflectedXSSExecutionPoint]').balloon();
		$('[ParameterPollutionInjectionPoint]').attr("title", "<?php echo $lParameterPollutionInjectionPointBallonTip; ?>");
		$('[ParameterPollutionInjectionPoint]').balloon();
	});
</script>

<div class="page-title">User Poll</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-menu-wrapper.inc'); ?>

<fieldset>
	<legend>User Poll</legend>
	<form 	action="index.php" 
			method="GET"
			enctype="application/x-www-form-urlencoded" 
			id="idPollForm">
		<input type="hidden" name="page" value="user-poll.php" />
		<input name="csrf-token" type="hidden" value="<?php echo $lNewCSRFTokenForNextRequest; ?>" />
		<table style="margin-left:auto; margin-right:auto;">
			<tr id="id-bad-vote-tr" style="display: none;">
				<td class="error-message">
					Validation Error: HTTP Parameter Pollution Detected. Vote cannot be trusted.
				</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td id="id-poll-form-header-td" class="form-header">Choose Your Favorite Security Tool</td>
			</tr>
			<tr><td></td></tr>
			<tr><th class="label">Initial your choice to make your vote count</th></tr>
			<tr><td></td></tr>
			<tr>
				<td>
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="nmap" checked="checked" />&nbsp;&nbsp;nmap<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="wireshark" />&nbsp;&nbsp;wireshark<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="tcpdump" />&nbsp;&nbsp;tcpdump<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="netcat" />&nbsp;&nbsp;netcat<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="metasploit" />&nbsp;&nbsp;metasploit<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="kismet" />&nbsp;&nbsp;kismet<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="Cain" />&nbsp;&nbsp;Cain<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="Ettercap" />&nbsp;&nbsp;Ettercap<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="Paros" />&nbsp;&nbsp;Paros<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="Burp Suite" />&nbsp;&nbsp;Burp Suite<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="Sysinternals" />&nbsp;&nbsp;Sysinternals<br />
					<input name="choice" id="id_choice" type="radio" <?php echo $lHTMLControlAttributes ?> value="inSIDDer" />&nbsp;&nbsp;inSIDDer
				</td>
			</tr>
			<tr>
				<td class="label">
					Your Initials:<input type="text" name="initials" <?php echo $lHTMLControlAttributes ?> ParameterPollutionInjectionPoint="1" value="<?php echo $lUserInitials; ?>"/>
				</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td style="text-align:center;">
					<input name="user-poll-php-submit-button" class="button" type="submit" value="Submit Vote" />
				</td>
			</tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td class="report-header" ReflectedXSSExecutionPoint="1">
				<?php 
					if (!$lEncodeOutput){
						echo $lUserChoiceMessage; 
					}else{
						echo $Encoder->encodeForHTML($lUserChoiceMessage);
					}// end if 
				?>
				</td>
			</tr>
		</table>
	</form>
</fieldset>

<script type="text/javascript">
	try{
		document.getElementById("id_choice").focus();
	}catch(e){
		alert('Error trying to set focus on field choice: ' + e.message);
	}// end try
</script>

<?php
	if ($lHTTPParameterPollutionDetected) {
		echo '<script>document.getElementById("id-bad-vote-tr").style.display="";</script>'; 
	}// end if ($lHTTPParameterPollutionDetected)
?>

<?php
	if ($lFormSubmitted) {
		echo $lCSRFTokenHandler->generateCSRFHTMLReport();
	}// end if
?>