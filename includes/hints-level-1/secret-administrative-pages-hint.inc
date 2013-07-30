<table class="hint-table">
	<tr class="hint-header" 
		id="idSecretAdministrativePagesHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idSecretAdministrativePagesHintBody'), window.document.getElementById('idSecretAdministrativePagesHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idSecretAdministrativePagesHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Secret Administrative Pages Hints" src="./images/down_arrow_16_16.png" />
			Secret Administrative Pages Hints
		</td>
	</tr>
	<tr id="idSecretAdministrativePagesHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Secret Administrative Pages are surprisingly common. Developers assume that it
			is not possible to determine the URL so the pages are secure.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Try brute forcing the page names in the page parameter with 
			Burp-Intruder in sniper mode. Include some of the following 
			page names in the brute force list: 
			secret.php, admin.php, _adm.php, _admin.php, root.php, 
			administrator.php, auth.php, hidden.php,
	 		console.php, conf.php, _private.php, private.php, 
	 		access.php, control.php, control-panel.php, phpMyAdmin.php
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Same as discovery.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
	  		The phpinfo function dumps PHP server configuration information to a nice table.
			The phpMyAdmin.php hosts a secret phpMyAdmin console.
			<br/><br/>
		</td>
	</tr>
</table>