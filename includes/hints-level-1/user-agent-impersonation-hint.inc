<table class="hint-table">
	<tr class="hint-header" 
		id="idUserAgentImpersonationHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idUserAgentImpersonationHintBody'), window.document.getElementById('idUserAgentImpersonationHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idUserAgentImpersonationHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand User Agent Impersonation Hints" src="./images/down_arrow_16_16.png" />User Agent Impersonation Hints</td>
	</tr>
	<tr id="idUserAgentImpersonationHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			User Agent Impersonation is altering the configutation of the browser
			in order to change the browsers fingerprint so that the new
			fingerprint matches another browser.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			To get started impersonating a user-agent, try a tool 
			like User-Agent Switcher; a free 
			add-on for Firefox
			<br/><br/>
			Some of the configurations have to be changed by changing
			the browsers configuration. In Firefox, see about:config. Use
			Google to determine how to change the configuration values.
			<br/><br/>
			The validator on this page is itself a JavaScript. The validator
			source code can be read to determine what values are required. Also
			the javascript could be manipulated or even rewritten to beat the 
			challenge. There is no security in javascript.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler::$IntroductiontoUseragentImpersonation);?>
			<br/><br/>
		</td>
	</tr>
</table>