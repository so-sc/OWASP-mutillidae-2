			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Remote file inclusion allows an attacker to include file remote 
			(from the web servers point of view)
			possibly allowing code execution, denial of service, and data disclosure.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			The page displayed in Mutillidae is determined 
			by the value of the "page" parameter. What would happen the "page" 
			parameter was changed to a filename URI which is located on a remote 
			server but not
			intended to be served?
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			A URI can be used to specify a remote file such as 
			http://www.google.com.
			<br/><br/>
			Example: 
			<a href="index.php?page=http://www.google.com">index.php?page=http://www.google.com</a>
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->HowtoExploitLocalFileInclusionVulnerabilityusingBurpSuite);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->ISSA2013WebPentestingWorkshopPart6LocalRemoteFileInclusion);?>
			<br/><br/>