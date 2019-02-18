<?php
/**
* @entity avatars 
*/
class Asset  extends BaseEntity {

	/**
	* @column asset
	*/
	protected $asset ;
	
	
	function __construct() {
		parent::__construct() ;
	}
	
	public function getAsset() {
		return $this->asset ;
	}
	
	
}
	
?>


