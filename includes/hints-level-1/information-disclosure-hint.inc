			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Information Disclosure may result when internal information is
			disclosed to the user-agent (browser). These paths can be
			used in other attacks.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Attempt to discover if it is possible to cause errors by injecting
			all input parameters with characters that are reserved in various
			contexts. 
			Search web page sources (view source) for internal information
			disclosure.
			Search for custom administrative pages and administrative consoles
			such as phpMyAdmin installations.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Search pages with and without injection. Use the grep feature of
			Burp-Suite to seach for inappropriate information. Search for known
			common administrative consoles such as phpMyAdmin installations,
			Drupal and Wordpress consoles.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->DetermineHTTPMethodsusingNetcat);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->DetermineServerBannersusingNetcatNiktoandw3af);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->UsingNmaptoFingerprintHTTPserversandWebApplications);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->FindingCommentsandFileMetadatausingMultipleTechniques);?>
			<br/><br/>