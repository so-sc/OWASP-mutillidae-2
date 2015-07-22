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
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->IntroductiontoHTTPParameterPollution);?>
			<br/><br/>