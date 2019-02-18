<?php

require 'PropertyReflection.php';

	/**
	* @entity user
	*/
class User  {
		
		/**
		* @primary id
		*/
		public $id ;
		
		
		/**
		*	@join Avatar.id,avatarId
		*/
		private $avatar ;
		
		
		/**
		*	join User.id,friendId
		*/
		private $friend ;
		
		
		public function setId($val) {$this->id = $val ;}	
		public function getId() {return $this->id;}	
		
		
		public function setAvatar($val) {$this->avatar = $val ;}	
		public function getAvatar() {return $this->avatar;}	
		
		public function setfriend($val) {$this->friend = $val ;}	
		public function getfriend() {return $this->friend;}	
		
		
		function __construct() {

		}
		
		public function __toString() {
			return "User:  xxx" ;
		}
				

}

	/**
	* @entity avatars
	*/
class Avatar {
		

		/**
		* @column id
		*/
		private $id ;
		
		/**
		* @column asset
		*/
		private $asset ;
		
		public function setId($val) {$this->id = $val ;}	
		public function getId() {return $this->id;}	
		
		public function setAsset($val) {$this->asset = $val ;}	
		public function getAsset() {return $this->asset;}	
		
		public function __toString() {
			return "Avatar: id=>{$this->id} asset=>{$this->asset}" ;
		}
}
	
	$user = new User() ;

	$avatar = new Avatar() ;
	$avatar->setId(22) ;
	
	
	//PropertyReflection
	$propertyReflection = new PropertyReflection() ;
	$propertyReflection->reflect($user) ;
//	$propertyReflection->buildSelect($user) ;

	$user->setAvatar($avatar) ;
	$propertyReflection->reflect($user) ;
	
?>
