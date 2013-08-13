<?php
	/*
	 * @author: Jeremy Druin
	 */
?>

<div>&nbsp;</div>
<table class="tutorial">
	<tr class="tutorial-title">
		<td colspan="10">HTTP Parameter Pollution Tutorial</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			HTTP Parameter Pollution occurs when multiple parameters with the same name are sent to 
			a web page. The web server may exhibit odd behavior and process the request despite 
			having multiple parameters with the same name. There is nothing in the HTTP protocol that 
			forbids passing multiple parameters with the same name. Web application servers will 
			sometimes take the first parameter, the second parameter, or concatenate both together.
			This can allow an attacker to poison the input.
		</td>
	</tr>
	<tr>
		<td>
			The first step to HTTP Parameter Pollution is to locate all parameters, then duplicate and see
			how the web server reacts.
			<br/><br/>
			Try sending in two of the "choice" parameter. Note carefully which of the two PHP processes. 
		</td>
	</tr>
	<tr>
		<td>
			Change the value of the submit button. Add "&amp;choice=something" to the current value. This will create
			a second "choice" parameter in the GET. Note which choice parameter is actually processed. Is it the correct
			parameter or the injected parameter?  
		</td>
	</tr>
	<tr>
		<td>
			Change the value of the hidden parameter which comes before the real "choice" parameter. Add "&amp;choice=something" to the current value. This will create
			a second "choice" parameter in the GET. Note which choice parameter is actually processed. Is it the correct
			parameter or the injected parameter?  
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
</table>

