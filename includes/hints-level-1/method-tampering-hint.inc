<table class="hint-table">
	<tr class="hint-header" 
		id="idMethodTamperingHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idMethodTamperingHintBody'), window.document.getElementById('idMethodTamperingHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idMethodTamperingHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Method Tampering Hints" src="./images/down_arrow_16_16.png" />
			Method Tampering Hints
		</td>
	</tr>
	<tr id="idMethodTamperingHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Method Tampering can occur for several reasons. One is that developers
			sometimes fetch values using the "REQUEST" array. This allows the user to inject
			variables into either GET or POST and have the application process them. To
			cause parameter pollusion, a user can send parameters via POST which the developer
			thinks should be passed via the URL. The user could also pass a variable using both
			GET and POST. The application can be tricked by the bogus parameters.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Determine parameters needed for a valid request. If the page submits requests
			via POST, change the method to GET and observe if the request works properly.
			Reverse GET requests as well.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Method tampering can help with filter bypass and make cross site request
			forgery easier.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler::$DetermineHTTPMethodsusingNetcat);?>
			<br/><br/>
		</td>
	</tr>
</table>