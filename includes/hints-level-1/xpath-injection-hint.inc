<table class="hint-table">
	<tr class="hint-header" 
		id="idXPathInjectionHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idXPathInjectionHintBody'), window.document.getElementById('idXPathInjectionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idXPathInjectionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand XPath Injection Hints" src="./images/down_arrow_16_16.png" />XPath Injection Hints</td>
	</tr>
	<tr id="idXPathInjectionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			XPath Injection may result when an application uses
			user input to form an XPath query string, then passes that
			query string to an XPath search.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Attempt to inject XML reserved characters into input
			parameters and observe if XML parsing errors are 
			generated. Make a list of input parameters that appear 
			to be passed into an XML parser based on ths feedback.
			<br/><br/>
			For web services, check each input parameter specified in the 
			WSDL or WADL document for those of type XML.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Use information disclosed in error messages to determine at what
			file path the XML parser is parsing. Try to cause errors to occur using
			malformed XML, XML reserved characters, XML that starts with whitespace or 
			null characters, and XML that does not meet the XSL specification.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			Try this example in the username field
			<br/>
<code>
	admin&apos; or &apos;1&apos; = &apos;1
</code>	
			<br/><br/>
</td>
	</tr>
</table>