<?php
require('BaseEntity.php') ;
/**
* @entity posts
*/
class User  extends BaseEntity {

	/**
	* @join Avatar.id,avatarId 
	*/
	protected $avatar ;
	
	/**
	* @column peace 
	*/
	protected $xxx ;

		
	function __construct() {
		parent::__construct() ;
	}
	
	public function getAvatar() {
		return $this->avatar;
	}
	
	
}
	
?>


