
<div class="page-title">Access Mutillidae from Samurai/Backtrack over a Virtual Box "Host Only" network</div><br /><br />
<div>&nbsp;</div>
<div>Note: This tutorial assumes that Mutillidae is installed in a Virtual Box Windows XP machine and that Samurai and Mutillidae are installed in Virtual Box virtual machines as well.</div>
<div>&nbsp;</div>
<div>
	<ul>
		<li>In Virtual Box, create "host only" network adapters for the machine hosting Mutillidae and the machines hosting Samurai/Backtrack.</li>
		<li>Start all machines</li>
		<li>For the machine hosting Mutillidae, open the Windows Firewall and locate the network adapter for the "host only" network. Allow "web services" over port 80 for this adapter.</li>
		<li>On the Samurai/Backtrack machine, use "ifconfig" to determine the IP address for the "host only" adapter. Likely this adapter will fall in the range of 192.168.56.0/24</li>
		<li>On the machine hosting Mutillidae, locate the "htaccess" file in the "mutillidae" directory. If all defaults are used including running XAMPP and Windows XP is the operating system, then this file will be located at C:\xampp\htdocs\mutillidae\.htaccess.</li>
		<li>Edit the .htaccess file to allow connections from the IP address of the Samurai/Backtrack machine or optionally from a network range containing the Samurai/Backtrack IP address (i.e. - 192.168.56.0/24).</li>
		<li>Restart the Apache service on the machine hosting Mutillidae</li>
		<li>If the machine hosting Mutillidae is Windows XP SP 3 or higher, pinging the machine will be blocked by the firewall. Enable "ICMP Echo Requests" in the Windows Firewall to enable pings.</li>
		<li>
			Example .htaccess file<br/><br/>
			
			ErrorDocument 403 "By default, Mutillidae only allows access from localhost (127.*.*.*). Edit the .htaccess file to change this behavior (not recommended on a public network)."<br/>
			Order Deny,Allow<br/>
			Deny from all<br/>
			Allow from 127.<br/>
			Allow from 192.168.0.0/16<br/>
		</li>
	</ul>
</div>