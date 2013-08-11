
<?php
	/* Known Vulnerabilities: 
		Cross Site Scripting, 
		HTML injection,
		HTTP Parameter Pollution
	*/
		
	switch ($_SESSION["security-level"]){
   		case "0": // This code is insecure
   		case "1": // This code is insecure
   			// DO NOTHING: This is insecure		
			$lEncodeOutput = FALSE;
			$lProtectAgainstMethodSwitching = FALSE;
			$lHTTPParameterPollutionDetected = FALSE;
		break;
	    		
		case "2":
		case "3":
		case "4":
		case "5": // This code is fairly secure
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
			$lProtectAgainstMethodSwitching = TRUE;
			
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

   	// initialize message
  	$lDocumentToBeFramedMessage="No choice selected";
   	$lDocumentChosen=(isset($_REQUEST["PathToDocument"]));
   	
   	if ($lDocumentChosen){
		// if we want to enforce GET method, we need to be careful to specify $_GET
	   	if(!$lProtectAgainstMethodSwitching){
	   		$lDocumentToBeFramed = $_REQUEST["PathToDocument"];
	   	}else{
	   		$lDocumentToBeFramed = $_GET["PathToDocument"];
	   	}//end if 
   	}else{
   		$lDocumentToBeFramed="documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php";
   	}//end if

	// Encode output to protect against cross site scripting 
	if ($lEncodeOutput){
		$lDocumentToBeFramed = $Encoder->encodeForHTML($lDocumentToBeFramed);
	}// end if
		   	
	// if parameter pollution is not detected, print user choice 
   	if (!$lHTTPParameterPollutionDetected){
		$lDocumentToBeFramedMessage = "Currently viewing document &quot;{$lDocumentToBeFramed}&quot;";
   	}// end if isSet($_POST["document-viewer-php-submit-button"])
	   	   	
	$LogHandler->writeToLog("User chose to view document: " . $lDocumentToBeFramed);   	
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

<div class="page-title">Document Viewer</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-wrapper.inc'); ?>

<fieldset style="text-align: center;">
	<legend>Document Viewer</legend>
	<form 	action="index.php" 
			method="GET"
			enctype="application/x-www-form-urlencoded" 
			id="idDocumentForm">
		<input type="hidden" name="page" value="document-viewer.php" />
		<table style="margin-left:auto; margin-right:auto;">
			<tr id="id-bad-path-to-document-tr" style="display: none;">
				<td class="error-message">
					Validation Error: HTTP Parameter Pollution Detected. Input cannot be trusted.
				</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td id="id-document-viewer-form-header-td" class="form-header">Please Choose Document to View</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td style="text-align:left;">
					<input name="PathToDocument" id="id_path_to_document" type="radio" value="documentation/change-log.html" checked="checked" />&nbsp;&nbsp;Change Log<br />
					<input name="PathToDocument" id="id_path_to_document" type="radio" value="robots.txt" checked="checked" />&nbsp;&nbsp;Robots.txt<br />
					<input name="PathToDocument" id="id_path_to_document" type="radio" value="documentation/mutillidae-installation-on-xampp-win7.pdf" checked="checked" />&nbsp;&nbsp;Installation Instructions: Windows 7 (PDF)<br />
					<input name="PathToDocument" id="id_path_to_document" type="radio" value="documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php" checked="checked" />&nbsp;&nbsp;How to access Mutillidae over Virtual-Box-network<br />
				</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td style="text-align:center;">
					<input ParameterPollutionInjectionPoint="1" name="document-viewer-php-submit-button" class="button" type="submit" value="View Document" />
				</td>
			</tr>
		</table>
	</form>

	<div>&nbsp;</div>
	<div class="label" ReflectedXSSExecutionPoint="1">
	<?php 
		if (!$lEncodeOutput){
			echo $lDocumentToBeFramedMessage; 
		}else{
			echo $Encoder->encodeForHTML($lDocumentToBeFramedMessage);
		}// end if 
	?>
	</div>
	<div>&nbsp;</div>
	<iframe src="<?php echo $lDocumentToBeFramed; ?>" width="700px" height="500px"></iframe>
</fieldset>

<?php
	if ($lHTTPParameterPollutionDetected) {
		echo '<script>document.getElementById("id-bad-path-to-document-tr").style.display="";</script>'; 
	}// end if ($lHTTPParameterPollutionDetected)
?>

<?php
	// Begin hints section
	if ($_SESSION["showhints"]) {
		echo '
			<table>
				<tr><td class="hint-header">Hints</td></tr>
				<tr>
					<td class="hint-body">
						<br/><br/>
						<span class="report-header">HTTP Parameter Pollution</span>
						<br/><br/>
						<ul class="hints">
						  	<li>
							  	HTTP Parameter Pollution involves sending in duplicate parameters 
							  	in order to take advantage of how the application server reacts to 
							  	parsing multiple parameters with the same name.
							</li>
						  	<li>
							  	Each brand of web application server acts a little different when 
							  	two or more parameters with the same name are submitted.
							</li>
							<li>This page implements "GET for POST" to make this exercise easier</li>
						</ul>
						<br/><br/>
						<span class="report-header">Frame Source Injection</span>
						<br/><br/>
						<ul class="hints">
						  	<li>
							  	Frame Source Injection is a specific type of HTML injection (HTMLi). 
							  	A sub-type of HTML injection (HTMLi) called HTMLi attribute
							  	injection occurs when user-supplied input is placed into an HTML
							  	attribute. For example, if a form field is output into an anchor
							  	tag HREF attribute without being output encoded, HTMLi attribute
							  	injection may occur. When the HTML attribute susceptible to injection
							  	happens to be the SRC attribute of a &lt;frame&gt; or &lt;iframe&gt;
							  	tag, then Frame Source Injection may occur. In reality all HTMLi attribute
							  	injection is dangerous, but some web vulnerability scanners will
							  	check specfically for this one particular variant because exploits
							  	can result in phishing and user-redirection attacks that are virtually
							  	undetectable even by seasoned users. 
							</li>
						  	<li>
							  	Does the page use any frames?
							</li>
							<li>
							  	Try to determine which user input if any is able to influence the source
							  	attribute (SRC) of a frame tag
							</li>
						  	<li>
							  	What happens if another page from this site is injected into a field
							  	that is able to able to influence the source
							  	attribute (SRC) of a frame tag?
							</li>
						  	<li>
							  	What happens if the URL of anohter web site is injected into a field
							  	that is able to able to influence the source
							  	attribute (SRC) of a frame tag? (Note: XAMPP contains sites by default such 
							  	as http://localhost/
							</li>
							<br/>
					</td>
				</tr>
			</table>'; 
	}//end if ($_SESSION["showhints"])
	
	if ($_SESSION["showhints"] == 2) {
		include_once '/includes/hints-level-2/http-parameter-pollution-tutorial.inc';
		include_once '/includes/hints-level-2/cross-site-scripting-tutorial.inc';
	}// end if
	
?>

<script type="text/javascript">
	try{
		document.getElementById("id_path_to_document").focus();
	}catch(e){
		alert('Error trying to set focus on field path_to_document: ' + e.message);
	}// end try
</script>
