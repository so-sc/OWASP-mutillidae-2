<?php

class YouTubeVideo{
	public $mIdentificationToken = "";
	public $mName = "";
}// end class

class YouTubeVideos{

	private $mVideos = array(); 

	private function createYouTubeVideo($pIdentificationToken, $pName){
		$lNewYouTubeVideo = new YouTubeVideo();
		$lNewYouTubeVideo->mIdentificationToken = $pIdentificationToken;
		$lNewYouTubeVideo->mName = $pName;
		return $lNewYouTubeVideo;
	}//end function CreateYouTubeVideo()

	private function createYouTubeVideos(){
		$this->mVideos['SSL_STRIPPING'] = $this->createYouTubeVideo("n_5NGkOnr7Q","SSL Striping");
	}//end function

	public function getYouTubeVideo($pID){
		return $this->mVideos[$pID];		
	}// end function

	public function __construct(){
		$this->createYouTubeVideos();
	}//end function

}// end class

class YouTubeVideoHandler {
	
	/* private properties */
	private $mMySQLHandler = null;
	private $mSecurityLevel = 0;
	private $mYouTubeVideos = null;
	
	/* public properties */
	public static $SSL_STRIPPING = 'SSL_STRIPPING';
	
	/* constructor */
	public function __construct($pPathToESAPI, $pSecurityLevel){
	
		$this->doSetSecurityLevel($pSecurityLevel);
	
		/* Initialize MySQL Connection handler */
		//require_once ('MySQLHandler.php');
		//$this->mMySQLHandler = new MySQLHandler($pPathToESAPI, $pSecurityLevel);
		//$this->mMySQLHandler->connectToDefaultDatabase();
		
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
	
	private function decodeVideoURL($pVideo){
		switch ($pVideo){
			case $this::$SSL_STRIPPING: return "n_5NGkOnr7Q"; break;
				
		}//end switch
	}//end function decodeVideoURL
	
	public function getYouTubeVideo($pVideo) {
		$data="";
		$lYouTubeResponse = "";
		$lHTML = "";
		$this->mYouTubeVideos = new YouTubeVideos();
		$lVideo = $this->mYouTubeVideos->getYouTubeVideo($this::$SSL_STRIPPING);
		$lVideoIdentificationToken = $lVideo->mIdentificationToken;
		$lVideoName = $lVideo->mName;
		
		try {
			if (function_exists("curl_init")) {
				$timeout = 5;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://gdata.youtube.com/feeds/api/videos/".$lVideoIdentificationToken);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$lYouTubeResponse = curl_exec($ch);
				curl_close($ch);
			}else{				
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