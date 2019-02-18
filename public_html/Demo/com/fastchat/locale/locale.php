<?php
namespace com\fastchat\locale ;



	 class Locale { 
		
		private $language ;

				
		public function __construct($language='en') {
        	$this->language = $language ;
		}

        
		public function text($token) {
			return $token ;
        }  

		public function setLanguage($language) {
			$this->language = $language ;
		}

		public function getLanguage() {
			return $this->language ;
		}
		

	}
	
	
?>
