<?php
require('EntityReflection.php') ;

class BaseEntity extends EntityReflection {
	/**
	* @primary id
	* @generated autoincremented
	*/
	protected $id ;

	/**
	* @column created
	*/
	protected $created  ;

	/**
	* @column updated
	*/
	protected $updated  ;
	
	function __construct() {
		
		parent::__construct() ;
	}
	
	
	public function getId() { return $id ; }
	public function setId($val) { $id = $val ; }


}

?>
