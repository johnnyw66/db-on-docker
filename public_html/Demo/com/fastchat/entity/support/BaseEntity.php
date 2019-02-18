<?php
require('EntityReflection.php') ;

class BaseEntity extends EntityReflection {
	/**
	* @primary id
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
	
}

?>
