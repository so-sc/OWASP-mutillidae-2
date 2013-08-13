<table class="hint-table">
	<tr class="hint-header" 
		id="idDOMInjectionHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idDOMInjectionHintBody'), window.document.getElementById('idDOMInjectionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idDOMInjectionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand DOM Injection Hints" src="./images/down_arrow_16_16.png" />
			DOM Injection Hints
		</td>
	</tr>
	<tr id="idDOMInjectionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			DOM Injection may occcur when the web page uses DOM manipulation to update
			the HTML of the page in response to user input. This is typically done
			using JavaScript.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Locate pages which use DOM manipulation to update the page without 
			returning to the server. This can often be detected when a client proxy
			such as Burp does NOT intercept a request when a page updates.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Inject the field or event from which the page will be updated and inject HTML or
			JavaScript into the field or event.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			Use Firebug or similar to examine the message that appears when a new
			item is added to storage. The message appears in a label below the two input fields.
			Inject XSS into the "key" field. This is output
			into the message. Craft a XSS to read the DOM storage or perform other 
			action.  
			<br/><br/>
		</td>
	</tr>
</table>