<table class="hint-table">
	<tr class="hint-header" 
		id="idCommandInjectionHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idCommandInjectionHintBody'), window.document.getElementById('idCommandInjectionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idCommandInjectionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Command Injection Hints" src="./images/down_arrow_16_16.png" />
			Command Injection Hints
		</td>
	</tr>
	<tr id="idCommandInjectionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Command Injection may occcur when an attacker is able to run script
			into a users browser. To forge a legitimate request, the script creates and
			send the same parameters to the target website that would be sent if the user
			had submitted the legitimate form themselves. The target website knows the 
			request has come from the users browser but cannot detect that the request was
			created and sent by a malicious script running in the users browser. As far as
			the target site can tell, the user submitted the request by using the web site
			in the expected way.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Fuzz with command separators like ;, &amp; and &amp;&amp; depending on if
			you are using Linux or Windows respectively. Look for errors
			that are related to operating system errors, delays in responses
			which can be repeated by repeating the injection, or unexpected
			output in the response. The error may appear as an HTML comment.
			<br/><br/>
			Attempt to determine the operating system type.
			<br/><br/>
			<span class="label">Reserved characters used in fuzzing for command injection</span>
			<br/><br/>
			<span class="label">&amp;</span>: Used to separate multiple commands on one command line. 
			Runs the first command then the second command.
			<br/><br/>
			<span class="label">&amp;&amp;</span>: Used to run the command following &amp;&amp; only if the 
			preceding command is successful. 
			<br/><br/>
			<span class="label">|| (Windows)</span>: Used to run the command following || only if the preceding command fails. 
			Runs the first command then runs the second command only if the 
			first command did not complete successfully.
			<br/><br/>
			<span class="label">|| (Linux)</span>: Redirects standard output of the first command to standard input
			of the second command.
			<br/><br/>
			<span class="label">( )</span>: Use to nest commands.
			<br/><br/>
			<span class="label">#</span>: Command line comment symbol
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Inject operating system commands methodically. "ls" and "dir" are reasonably
			good commands to attempt since most user accounts will have permission to
			execute directory listings by default and these two commands tend to 
			be exclusive (Windows will not typically execute "ls" and Linux will typically
			not execute "dir" but this behavior absolutely varies)
			<br/><br/>
			Prefix the injections with each of the reserved characters then for each prefix
			suffix each injection as well.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->CommandInjectiontoDumpFilesStartServicesandDisableFirewall);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->HowtoLocatetheEastereggFileusingCommandInjection);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->GainingAdministrativeShellAccessviaCommandInjection);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->UsingCommandInjectiontoGainRemoteDesktop);?>
			<br/><br/>
		</td>
	</tr>
</table>