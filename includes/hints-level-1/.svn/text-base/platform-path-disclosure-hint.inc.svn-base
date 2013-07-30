<table class="hint-table">
	<tr class="hint-header" 
		id="idPlatformPathDisclosureHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idPlatformPathDisclosureHintBody'), window.document.getElementById('idPlatformPathDisclosureHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idPlatformPathDisclosureHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Platform Path Hints" src="./images/down_arrow_16_16.png" />Platform Path Hints</td>
	</tr>
	<tr id="idPlatformPathDisclosureHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Platform Path Disclosure may result when internal system paths 
			are disclosed to the user-agent (browser). These paths can be
			used in other attacks such as directory browsing.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Attempt to discover if it is possible to cause errors by injecting
			all input parameters with characters that are reserved in various
			contexts. Search web page sources (view source) for internal system
			paths.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Note if the web server is Linux or Windows based. 
			Search pages with and without injection. Use the grep feature of
			Burp-Suite to seach for platform path patterns that match
			the web server operating system type. 
			<br/><br/>
		</td>
	</tr>
</table>