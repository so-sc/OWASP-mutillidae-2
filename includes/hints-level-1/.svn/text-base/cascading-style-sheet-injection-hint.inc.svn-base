<table class="hint-table">
	<tr class="hint-header" 
		id="idCSSInjectionHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idCSSInjectionHintBody'), window.document.getElementById('idCSSInjectionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idCSSInjectionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Cascading Style Injection Hints" src="./images/down_arrow_16_16.png" />Cascading Style Injection Hints</td>
	</tr>
	<tr id="idCSSInjectionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Cascading style injection may occcur
			when user or attacker controlled input is later incorporated 
			without being encoded into the web server response with a style attribute.
			In other words, the attacker
			can send input which later is incorporated into the web page the user receives.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Inject all available parameters of the web page with a searchable string
			such as the word "CANARY" along with characters generally useful in 
			writing HTML, JavaScript or other code. Search the response carefully
			noting any location where the test string appears unencoded in a style attribute. 
			These locations may allow Cascading style injection.
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
			<span class="report-header">Example</span>
			<br/><br/>
			Example Target:&lt;body style="color:#{dynamic input}"&gt;
			<br/><br/>
			Possible Solution:<span class="label">style="&lt;body color:#"<span style="color:red;">"&gt;&lt;H1&gt;HELLO WORLD&lt;/H1&gt;&lt;</span> anything="</span>"&gt;
			<br/><br/>
		</td>
	</tr>
</table>