<?php 
	class CSRFTokenStructure{ 
		private $mCSRFToken = ""; 
		private $mPage = "";
		private $mUser = "";
		
		public function __construct($pPage, $pUser){
			if (CRYPT_BLOWFISH == 1) {
				$lCSRFToken = crypt(mt_rand(), '$2a$10$'.mt_rand());
			}elseif (CRYPT_MD5 == 1){
				$lCSRFToken = crypt(mt_rand(), '$1$'.mt_rand());
			}else{
				$lCSRFToken = mt_rand();
			}// end if
			
			$this->mCSRFToken = $lCSRFToken; 
			$this->mPage = $pPage;
			$this->mUser = $pUser;
				
		}// end function

		public function getCSRFToken(){
			return $this->mCSRFToken;
		}// end function
			
	}// end class
?>