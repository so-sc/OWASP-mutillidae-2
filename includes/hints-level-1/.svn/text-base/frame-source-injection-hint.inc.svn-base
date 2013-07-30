<table class="hint-table">
	<tr class="hint-header" 
		id="idFrameSourceInjectionHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idFrameSourceInjectionHintBody'), window.document.getElementById('idFrameSourceInjectionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idFrameSourceInjectionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Frame Source Injection Hints" src="./images/down_arrow_16_16.png" />
			Frame Source Injection Hints
		</td>
	</tr>
	<tr id="idFrameSourceInjectionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Frame Source Injection may occcur when the src attribute of a frame or
			iframe is determined by a parameter sent by the client. In this case the
			client can send an unintended URI which may be displayed in the frame. 
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Inject canaries into each available parameter and cookie. Observe if any
			canary is found in the src attribute of a frame.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Inject a URI into the parameter found.Prefix and/or suffix the injections to 
			generate correct syntax.
			<br/><br/>
		</td>
	</tr>
</table>