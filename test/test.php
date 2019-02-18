<?php
require 'PropertyReflection.php';
require 'Entity.php';

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
		* @primary id
		*/
		private $id ;
		
		/**
		* @column asset
		*/
		private $asset ;
		
		
		/**
		*	@join User.id,ownerId
		*/
		private $owner ;
		
		
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
//	$propertyReflection = new PropertyReflection() ;
//	$propertyReflection->reflect($user) ;
//	echo "...end..." ;
//	$propertyReflection->buildSelect($user) ;

//	$user->setAvatar($avatar) ;
//	$propertyReflection->reflect($user) ;
	
//	$entity = new Entity('user',null,null) ;
//	echo "$entity\n" ;
	
	$entityUser = new Entity('users',null) ;
	$entityUser->setProperty('id',null,'id',$entityUser) 
		->setProperty('firstname',null,'firstname',$entityUser) 
		->setProperty('surname',null,'surname',$entityUser) 
		->setProperty('email',null,'email',$entityUser) 
		->setPrimaryKey('id') ;
	
	
	$entityAsset = new Entity('avatars',null,$entityUser,new EntityJoin('id','avatarId')) ;
	
	$entityAsset->setProperty('id',null,'id',$entityAsset) 
				->setProperty('asset',null,'asset',$entityAsset) 
				->setProperty('firstname','Oscar','firstname',$entityUser) 
				->setPrimaryKey('id') ;

	
	$flist = $entityUser->buildFieldList() ;
	$tlist = $entityUser->buildTableList() ;
	$clist = $entityUser->buildConditionList() ;
	
	echo "SELECT $flist\n" ;
	echo "$tlist\n" ;
	echo "$clist\n" ;
	

?>
