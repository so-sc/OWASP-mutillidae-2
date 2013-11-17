<table class="hint-table">
	<tr class="hint-header" 
		id="idApplicationLogInjectionHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idApplicationLogInjectionHintBody'), window.document.getElementById('idApplicationLogInjectionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idApplicationLogInjectionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Application Log Injection Hints" src="./images/down_arrow_16_16.png" />Application Log Injection Hints</td>
	</tr>
	<tr id="idApplicationLogInjectionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Application Log Injection may result when application logs store user
			input and possess client-vulnerabilities such as XSS. For example, if 
			application logs are stored in HTML format and viewed in a browser, then
			XSS vulnerabilities in the log viewer could allow execution of the XSS.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			To discover vulnerabilities in the log viewer, it may be best to download and
			install a copy of the target application locally, then use standard techniques
			to test the application.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Cross site scripting tends to be the easiest and most prevalent vulnerability
			in HTML based application log viewers. Send hooks and other XSS into the logs.
			Wait for an administrator to view the logs. 
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			The user name entered on the login page is logged to the application log. Enter
			a cross-site script in the user name field. Visit the 
			<a href="index.php?page=show-log.php">View Log</a> page. Check that the XSS works.
			<br/><br/>
		</td>
	</tr>
</table>