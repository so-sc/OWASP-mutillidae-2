<table class="hint-table">
	<tr class="hint-header" 
		id="idParameterPollutionHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idParameterPollutionHintBody'), window.document.getElementById('idParameterPollutionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idParameterPollutionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Parameter Pollution Hints" src="./images/down_arrow_16_16.png" />
			Parameter Pollution Hints
		</td>
	</tr>
	<tr id="idParameterPollutionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Parameter pollution results when multiple copies of the same 
			parameter are submitted in the same request. Some web servers
			will take the first copy, some the last copy, and some
			will combine all the values of the parameters.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Choose any parameter and duplicate that parameter. Give the copy
			a different value to make detection easier. Submit the request and 
			observer how the web server deals with the polluted parameter.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Once it is know how the web server will use the parameters, use
			parameter pollution. For example, if the web server concatenates values, submit
			half of the payload in the first copy and half in the second allowing
			the web server to put the values together. This allows WAF and validation
			bypass in some cases.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler::$IntroductiontoHTTPParameterPollution);?>
			<br/><br/>
					</td>
	</tr>
</table>