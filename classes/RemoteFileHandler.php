<?php
class RemoteFileHandler {

	/* private properties */
	private $mSecurityLevel = 0;
	private $mCurlIsInstalled = false;
	
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

	private function doCurlIsInstalled(){
		return function_exists("curl_init");
	}// end function doCurlIsInstalled

	/* public methods */
	/* constructor */
	public function __construct($pPathToESAPI, $pSecurityLevel){
		$this->doSetSecurityLevel($pSecurityLevel);
		$this->mCurlIsInstalled = $this->doCurlIsInstalled();
	}// end function __construct

	public function curlIsInstalled(){
		return $this->mCurlIsInstalled;
	}// end function isCurlInstalled

	public function remoteSiteIsReachable($pPage){
		try{
			if ($this->mCurlIsInstalled){
				$ch = curl_init($pPage);
				curl_setopt($ch, CURLOPT_NOBODY, true);
				/* Status 4xx: Client messed up, Status 5xx: Server messed up */
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$data = curl_exec($ch);
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				/* Status 4xx: Client messed up, Status 5xx: Server messed up */
				return (startsWith($httpCode, '2') || startsWith($httpCode, '3') || startsWith($httpCode, '1'));
			}// end if $mCurlIsInstalled
		} catch (Exception $e) {
			return false;
		}//end try
	}// end function

	public function getNoCurlAdviceBasedOnOperatingSystem(){
		$lOperatingSystemAdvice = "";
		$lHTML = "";
		
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
		
		$lHTML = '<br/><span style="background-color: #ffff99;">Warning: Detected PHP Curl is not installed on the server. This may cause issues detecting or downloading remote files. '.$lOperatingSystemAdvice.'</span><br/><br/>';
		return $lHTML;
	}// end function getNoCurlAdviceBasedOnOperatingSystem

}// end class
?>
