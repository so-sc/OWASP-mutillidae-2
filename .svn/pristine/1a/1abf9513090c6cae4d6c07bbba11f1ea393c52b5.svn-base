<table class="hint-table">
	<tr class="hint-header" 
		id="idJavascriptValidationBypassHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idJavascriptValidationBypassHintBody'), window.document.getElementById('idJavascriptValidationBypassHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idJavascriptValidationBypassHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Javascript Validation Bypass Hints" src="./images/down_arrow_16_16.png" />Javascript Validation Bypass Hints</td>
	</tr>
	<tr id="idJavascriptValidationBypassHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Javascript Validation Bypass is usually trivial since the user 
			may disable Javascript entirely or fill in values which legitimately 
			pass validation then alter those values in a client proxy such as
			Burp Suite after the validation has occured.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Set up a client proxy to capture all requests. Observe if validation
			occurs prior to the request being captured. If so, the validation is
			occuring in the browser.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Disable Javascript entirely and observe if the page still operates. 
			Alternatively fill in values which legitimately 
			pass client-side validation then alter those values 
			in a client proxy such as
			Burp Suite after the validation has occured.
			<br/><br/>
		</td>
	</tr>
</table>