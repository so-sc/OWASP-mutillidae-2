<?php 
	require_once (__ROOT__.'/classes/YouTubeVideoHandler.php');
	$YouTubeVideoHandler = new YouTubeVideoHandler("owasp-esapi-php/src/", $_SESSION["security-level"]);
	$lVideoHTML = $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler::$SSL_STRIPPING);
?>

<table class="hint-table">
	<tr class="hint-header" 
		id="idSSLMisconfigurationHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idSSLMisconfigurationHintBody'), window.document.getElementById('idSSLMisconfigurationHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idSSLMisconfigurationHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand SSL Misconfiguration Hints" src="./images/down_arrow_16_16.png" />SSL Misconfiguration Hints</td>
	</tr>
	<tr id="idSSLMisconfigurationHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			SSL Misconfiguration causes a variety of issues such as sensitive pages being
			accessible via HTTP, use of weak SSL ciphers, and SSL stripping.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Use an SSL cipher audit tool such as SSLScan to test cipher strength. Observe 
			how the site handles an HTTP request. If the site redirects the user to 
			HTTPS, the site can be stripped. 
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			<?php echo $lVideoHTML;	?>
			<br/><br/>
		</td>
	</tr>
</table>