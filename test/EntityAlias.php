<?php

class EntityAlias {

	private static $count = 0;

	public static function reset() {
		EntityAlias::$count = 0; 
	}
	
	public static function createEntityAlias($entityName) {
		return $entityName."".EntityAlias::$count++ ;
	}

}
?>