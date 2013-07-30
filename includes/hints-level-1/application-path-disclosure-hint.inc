<table class="hint-table">
	<tr class="hint-header" 
		id="idApplicationPathDisclosureHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idApplicationPathDisclosureHintBody'), window.document.getElementById('idApplicationPathDisclosureHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idApplicationPathDisclosureHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Application Path Disclosure Hints" src="./images/down_arrow_16_16.png" />Application Path Disclosure Hints</td>
	</tr>
	<tr id="idApplicationPathDisclosureHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Application Path Disclosure may result when internal application paths 
			are disclosed to the user-agent (browser). These paths can be
			used in other attacks such as forced browsing.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Attempt to discover if it is possible to cause errors by injecting
			all input parameters with characters that are reserved in various
			contexts. Search web page sources (view source) for internal application
			paths.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Search pages with and without injection. Use the grep feature of
			Burp-Suite to seach for application path patterns that match
			the web application framework type. 
			<br/><br/>
		</td>
	</tr>
</table>