<?php

require_once ('SQLQueryHandler.php');

class YouTubeVideo{
	public $mIdentificationToken = "";
	public $mTitle = "";
}// end class

class YouTubeVideos{

	private $mSQLQueryHandler = null;

	public function __construct(){
		/* ------------------------------------------
		 * initialize SQLQuery handler
		* ------------------------------------------ */
		$this->mSQLQueryHandler = new SQLQueryHandler("./owasp-esapi-php/src/", $_SESSION["security-level"]);
	
	}//end function
	
	public function getYouTubeVideo($pRecordIdentifier){
		$lQueryResult = $this->mSQLQueryHandler->getYouTubeVideo($pRecordIdentifier);
		$lNewYouTubeVideo = new YouTubeVideo();
		$lNewYouTubeVideo->mIdentificationToken = $lQueryResult->identificationToken;
		$lNewYouTubeVideo->mTitle = $lQueryResult->title;
		return $lNewYouTubeVideo;
	}//end function CreateYouTubeVideo()

}// end class YouTubeVideos

class YouTubeVideoHandler {
	
	/* private properties */
	private $mSecurityLevel = 0;
	private $mYouTubeVideos = null;

	/* public properties */
	public static $SSL_STRIPPING = 1;

	/* constructor */
	public function __construct($pPathToESAPI, $pSecurityLevel){
		$this->doSetSecurityLevel($pSecurityLevel);
		$this->mYouTubeVideos = new YouTubeVideos();
	}// end function __construct

	/* private methods */
	private function doSetSecurityLevel($pSecurityLevel){
		$this->mSecurityLevel = $pSecurityLevel;
	
		switch ($this->mSecurityLevel){
			case "0": // This code is insecure, we are not encoding output
			case "1": // This code is insecure, we are not encoding output
				break;
	
			case "2":
			case "3":
			case "4":
			case "5": // This code is fairly secure
				break;
		}// end switch
	}// end function
		
	private function fetchVideoPropertiesFromYouTube($pVideoIdentificationToken){
		$lYouTubeResponse = "";
		
		try{
			if (function_exists("curl_init")) {
				$timeout = 5;
				$lCurlInstance = curl_init();
				curl_setopt($lCurlInstance, CURLOPT_URL, "http://gdata.youtube.com/feeds/api/videos/".$pVideoIdentificationToken);
				curl_setopt($lCurlInstance, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($lCurlInstance, CURLOPT_CONNECTTIMEOUT, $timeout);
				$lYouTubeResponse = curl_exec($lCurlInstance);
				curl_close($lCurlInstance);
			}//end if
		} catch (Exception $e) {
			//do nothing
		}//end try
		
		return $lYouTubeResponse;
	}// end function fetchVideoPropertiesFromYouTube
	
	public function getYouTubeVideo($pVideo) {
		$lYouTubeResponse = "";
		$lHTML = "";
		$lVideo = $this->mYouTubeVideos->getYouTubeVideo($this::$SSL_STRIPPING);
		$lVideoIdentificationToken = $lVideo->mIdentificationToken;
		$lVideoTitle = $lVideo->mTitle;
		$lOperatingSystemAdvice = "";
		
		try {
			$lYouTubeResponse = $this->fetchVideoPropertiesFromYouTube($lVideoIdentificationToken);
			if (strlen($lYouTubeResponse) == 0) {
				switch (PHP_OS){
					case "Linux": 
						$lOperatingSystemAdvice = "The server operating system seems to be Linux. You may be able to install with sudo apt-get install php5-curl";
						break;
					case "WIN32":
					case "WINNT":
					case "Windows": 
						$lOperatingSystemAdvice = "The server operating system seems to be Windows. You may be able to enable by uncommenting extension=php_curl.dll in the php.ini file and restarting apache server.";
						break;
					default: $lOperatingSystemAdvice = ""; break;
				}// end switch

				$lHTML .= '<span style="background-color: #ffffcc;">Warning: Failed to embed video because PHP Curl is not installed on the server. '.$lOperatingSystemAdvice.'</span><br/><br/>';			
			}// end if
		} catch (Exception $e) {
			//do nothing
		}//end try

		$lHTML .= '<span class="label">Mutillidae: Using ettercap and sslstrip to capture login</span><br/><br/>';
				
		if(strlen($lYouTubeResponse) > 0){
			$lHTML .= '<iframe width="640px" height="480px" src="https://www.youtube.com/embed/'.$lVideoIdentificationToken.'" frameborder="0" allowfullscreen="1"></iframe>';
		}else {
			$lHTML .= '<a href="https://www.youtube.com/watch?v='.$lVideoIdentificationToken.'" target="_blank">Mutillidae: Using ettercap and sslstrip to capture login</a>';
		}// end if
	
		return $lHTML;
		
	}// end function getYouTubeVideo
	
}// end class YouTubeVideoHandler