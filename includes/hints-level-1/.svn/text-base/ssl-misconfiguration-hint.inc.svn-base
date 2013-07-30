<table class="hint-table">
	<tr class="hint-header" 
		id="idSSLMisconfigurationHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idSSLMisconfigurationHintBody'), window.document.getElementById('idSSLMisconfigurationHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idSSLMisconfigurationHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand SSL Misconfiguration Hints" src="./images/down_arrow_16_16.png" />SSL Misconfiguration Hints</td>
	</tr>
	<tr id="idSSLMisconfigurationHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			SSL Misconfiguration causes a variety of issues such as sensitive pages being
			accessible via HTTP, use of weak SSL ciphers, and SSL stripping.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Use an SSL cipher audit tool such as SSLScan to test cipher strength. Observe 
			how the site handles an HTTP request. If the site redirects the user to 
			HTTPS, the site can be stripped. 
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			<span class="label">Mutillidae: Using ettercap and sslstrip to capture login</span>
			<br/><br/>
			<?php 
				/*
				 * This is just a prototype of things to come.
				 */
				/* gets the data from a URL */
				function get_data($url) {
					$data="";
					try {
						$ch = curl_init();
						$timeout = 5;
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
						$data = curl_exec($ch);
						curl_close($ch);
					} catch (Exception $e) {
						//do nothing
					}
					return $data;
				}// end function
	
				$lYouTubeResponse = get_data("http://gdata.youtube.com/feeds/api/videos/n_5NGkOnr7Q");
				
				if (strlen($lYouTubeResponse) > 0){
					echo '<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/n_5NGkOnr7Q" frameborder="0" allowfullscreen="1"></iframe>';					
				}else {
					echo '<a href="https://www.youtube-nocookie.com/embed/n_5NGkOnr7Q" target="_blank">Mutillidae: Using ettercap and sslstrip to capture login</a>';
				}// end if
			?>
			<br/><br/>
		</td>
	</tr>
</table>