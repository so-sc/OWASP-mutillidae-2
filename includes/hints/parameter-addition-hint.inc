		<br/><br/>
		<span class="report-header">Overview</span>
		<br/><br/>
	  	Parameter addition may occur if the user submits a new parameter the site
	  	was not expecting to see. The site will generally not validate parameters 
	  	that are unexpected. The classic case of sites outputting all parameters
	  	no matter whether the site uses the parameter is diagnostics. The developer
	  	may dump all parameters and their values regardless of whether the parameters
	  	was expected. 
		<br/><br/>
		<span class="report-header">Discovery Methodology</span>
		<br/><br/>
		Inject a new parameter that is not normally submitted by the application
		with a searchable string
		such as the word "CANARY" along with characters generally useful in 
		writing HTML, JavaScript or other code. Search the response carefully
		noting any location where the test string appears unencoded. These 
		locations may allow cross-site scripting. 
		<br/><br/>
		<span class="report-header">Exploitation</span>
		<br/><br/>
		Determine the prefix and suffix needed to make the injected code "fit" syntatically
		then add a payload between. Inject the exploit.
		<br/><br/>