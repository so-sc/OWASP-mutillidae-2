<?php 
	try {	    	
    	switch ($_SESSION["security-level"]){
    		case "0": // This code is insecure. No input validation is performed.
				$lEnableJavaScriptValidation = FALSE;
				$lProtectAgainstMethodTampering = FALSE;
				$lProtectAgainstCommandInjection=FALSE;
				$lProtectAgainstXSS = FALSE;
    		break;

    		case "1": // This code is insecure. No input validation is performed.
				$lEnableJavaScriptValidation = TRUE;
				$lProtectAgainstMethodTampering = FALSE;
				$lProtectAgainstCommandInjection=FALSE;
				$lProtectAgainstXSS = FALSE;
    		break;

	   		case "2":
	   		case "3":
	   		case "4":
    		case "5": // This code is fairly secure
    			$lProtectAgainstCommandInjection=TRUE;
    			$lEnableJavaScriptValidation = TRUE;
   				$lProtectAgainstMethodTampering = TRUE;
   				$lProtectAgainstXSS = TRUE; 			
    		break;
    	}// end switch
    	
    	$lFormSubmitted = FALSE;
		if (isset($_POST["target_host"]) || isset($_REQUEST["target_host"])) {
			$lFormSubmitted = TRUE;
		}// end if
		
		if ($lFormSubmitted){
			
	    	if ($lProtectAgainstMethodTampering) {
	    		$lTargetHost = $_POST["target_host"];
	    	}else{
	    		$lTargetHost = $_REQUEST["target_host"];
	    	}// end if $lProtectAgainstMethodTampering
	    	
	    	if ($lProtectAgainstCommandInjection) {
				/* Protect against command injection. 
				 * We validate that an IP is 4 octets, IPV6 fits the pattern, and that domain name is IANA format */
    			$lTargetHostValidated = preg_match(IPV4_REGEX_PATTERN, $lTargetHost) || preg_match(DOMAIN_NAME_REGEX_PATTERN, $lTargetHost) || preg_match(IPV6_REGEX_PATTERN, $lTargetHost);
	    	}else{
    			$lTargetHostValidated=TRUE; 			// do not perform validation
	    	}// end if
	    	
	    	if ($lProtectAgainstXSS) {
    			/* Protect against XSS by output encoding */
    			$lTargetHostText = $Encoder->encodeForHTML($lTargetHost);
	    	}else{
				$lTargetHostText = $lTargetHost; 		//allow XSS by not encoding output	    		
	    	}//end if
	    	
		}// end if $lFormSubmitted    	
    	
		try{
    		$lOSCommandInjectionPointBallonTip = $BubbleHintHandler->getHint("OSCommandInjectionPoint");
       		$lReflectedXSSExecutionPointBallonTip = $BubbleHintHandler->getHint("ReflectedXSSExecutionPoint");
		} catch (Exception $e) {
			echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
		}// end try
    		    	    	
	}catch(Exception $e){
		echo $CustomErrorHandler->FormatError($e, "Error setting up configuration on page dns-lookup.php");
	}// end try	
?>

<div class="page-title">DNS Lookup</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-wrapper.inc'); ?>

<script type="text/javascript">
	$(function() {
		$('[OSCommandInjectionPoint]').attr("title", "<?php echo $lOSCommandInjectionPointBallonTip; ?>");
		$('[OSCommandInjectionPoint]').balloon();
		$('[ReflectedXSSExecutionPoint]').attr("title", "<?php echo $lReflectedXSSExecutionPointBallonTip; ?>");
		$('[ReflectedXSSExecutionPoint]').balloon();
	});
</script>
    
<!-- BEGIN HTML OUTPUT  -->
<script type="text/javascript">
	var onSubmitBlogEntry = function(/* HTMLForm */ theForm){

		<?php 
		if($lEnableJavaScriptValidation){
			echo "var lOSCommandInjectionPattern = /[;&]/;";
		}else{
			echo "var lOSCommandInjectionPattern = /*/;";
		}// end if

		if($lEnableJavaScriptValidation){
			echo "var lCrossSiteScriptingPattern = /[<>=()]/;";
		}else{
			echo "var lCrossSiteScriptingPattern = /*/;";
		}// end if
		?>
		
		if(theForm.target_host.value.search(lOSCommandInjectionPattern) > -1){
			alert("Ampersand and semi-colon are not allowed.\n\nDon\'t listen to security people. Everyone knows if we just filter dangerous characters, XSS is not possible.\n\nWe use JavaScript defenses combined with filtering technology.\n\nBoth are such great defenses that you are stopped in your tracks.");
			return false;
		}else if(theForm.target_host.value.search(lCrossSiteScriptingPattern) > -1){
			alert("Characters used in cross-site scripting are not allowed.\n\nDon\'t listen to security people. Everyone knows if we just filter dangerous characters, XSS is not possible.\n\nWe use JavaScript defenses combined with filtering technology.\n\nBoth are such great defenses that you are stopped in your tracks.");
			return false;			
		}else{
			return true;
		}// end if
	};// end JavaScript function onSubmitBlogEntry()
</script>

<form 	action="index.php?page=dns-lookup.php" 
			method="post" 
			enctype="application/x-www-form-urlencoded" 
			onsubmit="return onSubmitBlogEntry(this);"
			id="idDNSLookupForm">		
	<table style="margin-left:auto; margin-right:auto;">
		<tr id="id-bad-cred-tr" style="display: none;">
			<td colspan="2" class="error-message">
				Error: Invalid Input
			</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td colspan="2" class="form-header">Who would you like to do a DNS lookup on?<br/><br/>Enter IP or hostname</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td class="label">Hostname/IP</td>
			<td><input type="text" id="idTargetHostInput" name="target_host" size="20" OSCommandInjectionPoint="1" /></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<input name="dns-lookup-php-submit-button" class="button" type="submit" value="Lookup DNS" />
			</td>
		</tr>
		<tr><td></td></tr>
		<tr><td></td></tr>
	</table>
</form>

<script type="text/javascript">
<!--
	try{
		document.getElementById("idTargetHostInput").focus();
	}catch(/*Exception*/ e){
		alert("Error trying to set focus: " + e.message);
	}// end try
//-->
</script>

<?php
	if (isset($_POST["dns-lookup-php-submit-button"])){
	    try{
	    	if ($lTargetHostValidated){
	    		echo '<div class="report-header" ReflectedXSSExecutionPoint="1">Results for '.$lTargetHostText.'</div>';
    			echo '<pre class="report-header" style="text-align:left;">'.shell_exec("nslookup " . $lTargetHost).'</pre>';
				$LogHandler->writeToLog("Executed operating system command: nslookup " . $lTargetHostText);
	    	}else{
	    		echo '<script>document.getElementById("id-bad-cred-tr").style.display=""</script>';
	    	}// end if ($lTargetHostValidated){

    	}catch(Exception $e){
			echo $CustomErrorHandler->FormatError($e, "Input: " . $lTargetHost);
    	}// end try
    	
	}// end if (isset($_POST)) 
?>

<?php
	if ($_SESSION["showhints"] == 2) {
		include_once './includes/hints-level-2/command-injection-tutorial.inc';
	}// end if
	
	if ($_SESSION["showhints"] == 2) {
		include_once '/includes/hints-level-2/cross-site-scripting-tutorial.inc';
	}// end if
?>

