<div class="page-title">Usage Instructions</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>

<table>
	<tr>
		<td style="width:800px;">
	Mutillidae implements vulnerabilities from the <a href="http://www.owasp.org/index.php/OWASP_Top_Ten_Project" target="_blank">OWASP Top 10</a> 2010 and 2007 in PHP. 
	Additionally vulnerabilities from the SANS Top 25 Programming Errors and select information disclosure vulnerabilities have been exposed on various pages. 
	<br/><br/>
	A project whitepaper is available to explain the features of Mutillidae and suggested use-cases.
	<br/><br/>
	<a 
		href="https://www.sans.org/reading-room/whitepapers/application/introduction-owasp-mutillidae-ii-web-pen-test-training-environment-34380" 
		target="_blank"
		title="Whitepaper: Introduction to OWASP Mutillidae II Web Pen Test Training Environment"
	>			
		<img align="middle" alt="Webpwnized Twitter Channel" src="./images/pdf-icon-48-48.png" />
		Introduction to OWASP Mutillidae II Web Pen Test Training Environment
	</a>
	<br/><br/>
	The menu on the left is organized by category then vulnerability. Some vulnerabilities
	will be in more than one category as there is overlap between categories. Each
	page in Mutillidae will expose multiple vulnerabilities. Some pages have half a dozen
	and/or multiple critical vulnerabilities on the same page. The page will appear in the menu
	under each vulnerability.
	<br/><br/>
	A <a title="Listing of vulnerabilities" href="./index.php?page=./documentation/vulnerabilities.php">listing of vulnerabilities</a> 
	is available in menu under documentation or by clicking 
	<a title="Listing of vulnerabilities" href="./index.php?page=./documentation/vulnerabilities.php">here</a>.
	<br/><br/>
	<span class="report-header">Security Modes</span>
	<br/><br/>
	Mutillidae currently has two modes: secure and insecure (default). In insecure mode, the 
	project works like Mutillidae 1.0. Pages are vulnerable to at least the topic they 
	fall under in the menu. Most pages are vulnerable to much more. In secure mode, 
	Mutillidae attempts to protect the pages with server side scripts. Also, hints are disabled in
	secure mode. In the interest of making as many challenges as possible, this can be defeated.
	The mode can be changed using the "Toggle Security" button on the top menu bar. 
	<br/><br/>
	<span class="report-header">"Help Me" Button</span>
	<br/><br/>
	There are multiple "hint systems" built into each page. The "Help Me" button provides a basic
	description of the vulnerabilities on the page for which the user should try exploits. 
	<br/><br/>
	<span class="report-header">Bubble Hints</span>
	<br/><br/>
	If the 
	"Bubble Hints" are enabled (top menu bar), some of the vulnerable locations will have bubble
	hints pop up when the user hovers the mouse over the vulnerable field or area. 
	<br/><br/>
	<span class="report-header">Page Hints</span>
	<br/><br/>
	To get more hints,
	toggle the "Show Hints" button (top menu bar). A hints section will open at the bottom of the
	page. These are light-red in color. Toggling the "Show Hints" twice will show more detailed 
	hints on some pages. These will be in yellow boxes below the 1st-level hints. 
	<br/><br/>
	<span class="report-header">Just give me the exploit</span>
	<br/><br/>
	Known exploits that are used in testing Mutillidae are located in 
	/documentation/mutillidae-test-scripts.txt. There is some documentation for each exploit
	which explains usage and location.
	<br/><br/>
	Mutillidae is a "live" system. The vulnerabilities are real rather than emulated. This eliminates
	the frustration of having to "know what the author wants". Because of this, there are likely 
	undocumented vulnerabilities. Also, this project endangers any machine on which it runs. Best practice 
	is to run Mutillidae in a virtual machine isolated from the network which is only booted
	when using Mutillidae. Every effort has been made to make Mutillidae run entirely off-line
	to support best practice.
	<br/><br/>
	In Mutillidae 2.0, the code has been commented to allow the user to see how the defense works.
	To get the most out of the project, avoid reading the source code until after learning how
	to exploit it. But if you get stuck, the comments should help. Learning how the attack
	works should help to understand the defense.
		</td>
	</tr>
</table>