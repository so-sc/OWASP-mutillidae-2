<table class="hint-table">
	<tr class="hint-header" 
		id="idDirBrowsingHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idDirBrowsingHintBody'), window.document.getElementById('idDirBrowsingHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idDirBrowsingHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Directory Browsing Hints" src="./images/down_arrow_16_16.png" />
			Directory Browsing Hints
		</td>
	</tr>
	<tr id="idDirBrowsingHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Directory Browsing is allowed when the web server is misconfigured to show the
			user the contents of directories on the server.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Use search engines to look for pages which include "index of" in the title.
			Additionally attempt to read the robots.txt file and spider the application
			with a tool such as Burp-Suite, OWASP ZAP, or Nikto, and directories
			named by search engines.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Catalog and inspect the folders named in robots.txt and any directories
			discovered during spidering. Use a tool such as Burp-Intruder to brute-force
			sub-directory names in the root directory and other discovered directories. 
			<br/><br/>
		</td>
	</tr>
</table>