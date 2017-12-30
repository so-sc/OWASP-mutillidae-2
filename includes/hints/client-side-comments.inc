			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Applications may contain comments within the client-side source code. Common
			locations include HTML and JavaScript comments.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			While these comments are not visible in the browser, they can be seen by
			using the browsers "View Source"/"View Page Source" feature. Also, tools
			and techniques are availble to automatically parse comments from an
			entire site.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Comments can be seen in clear-text. Tools are available to help automate
			examination of entire sites.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			There is a sensitive comment on the Mutillidae Home page. Visit the 
			<a href="index.php?page=home.php">Home</a> page. View the page source
			to see comments.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->HowtouseWGETtocloneaWebSite);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->HowtoSweepaWebSiteforHTMLComments);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->FindingCommentsandFileMetadatausingMultipleTechniques);?>
			<br/><br/>			