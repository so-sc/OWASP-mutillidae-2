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
After ARP poisoning the client and the gateway, use SSLStrip to
remove SSL connection. 
<br/><br/>
<span class="report-header">Videos</span>
<br/><br/>
<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->UsingEttercapandSSLstriptoCaptureCredentials);?>
<br/><br/>
