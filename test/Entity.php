<?php

require('EntityAlias.php') ;
require('EntityJoin.php') ;
require('EntityProperty.php') ;

class Entity {

	protected $parent ;			// parent and child entities - root entity has no parent.
	protected $child ;			//

	protected $name ;			// Entity name from the '@entity' annotation
	protected $object ; 		// null if not an instance.
	protected $joinCondition ; 	//
	private $alias ;			// Entity alias used for forming SQL statements (formed from name and a unique index)
	private $primaryKey ;		
	private $properties ;		// List of decoded annotated '@column','@primary' references. (currently @prime does nothing extra)

	function __construct($name,$object = null,$parent = null,$joinCondition = null) {
			$this->parent 	= 	$parent ;
			$this->name		=	$name ;
			$this->object	=	$object ;
			$this->alias =	EntityAlias::createEntityAlias($name) ;
			$this->properties = array() ;
			$this->joinCondition = $joinCondition ;
			if ($parent != null) {
				$parent->addChild($this) ;
			}
			
	}

	
	public function setPrimaryKey($pkeyName) {
		$this->primaryKey = $pkeyName ;
		return $this ;
	}
	
	public function setProperty($propertyName,$propertyValue,$columnName,$entityReference) {
		// entityReference refers to the join reference
		$property = new EntityProperty($propertyName,$propertyValue,$columnName,$entityReference) ;
		array_push($this->properties, $property) ;
		return $this ;
	}
	
	public function buildFieldList() {
		$list = array() ;
		$ptr = $this ;
		while($ptr != null) {
			$entName = $ptr->name ;
			foreach($ptr->properties as $key => $property) {
				$columnName = $property->getColumnName() ;
				$idName = $property->getIdName() ;
				
				$columnSelect = "{$ptr->alias}.$columnName" ;
				$fieldAlias = "as $entName"."_"."{$ptr->alias}_$idName" ;				// use fieldnames and entity names to build column alias - since we need to know where to pop these values back into
				array_push($list,"$columnSelect $fieldAlias") ;
			}
			$ptr = $ptr->child ;
		}
		return implode($list,", ") ;
	}
	
	
	public function buildConditionList() {
		$list = array() ;
		$ptr = $this ;
		array_push($list,1) ;		// at least one condition is true
		while($ptr != null) {
			
			foreach($ptr->properties as $key => $property) {
				$columnName = $property->getColumnName() ;
				$propValue = $property->getPropertyValue() ;
				if ($propValue != null) {
					array_push($list,"{$ptr->alias}.$columnName = '$propValue'") ;
				}
			}
			$ptr = $ptr->child ;
		}
		return 'WHERE '.implode($list," AND  ") ;
	}
		
	public function buildTableList() {
		$ptr = $this ;
		$list = array() ;
		array_push($list,"FROM {$ptr->name} {$ptr->alias}\n") ;
		$ptr = $ptr->child ;
		
		while($ptr != null) {

			$leftJoin= $ptr->getLeftJoin() ;
			$rightJoin = $ptr->getRightJoin() ;
			
			array_push($list,"{$ptr->name} {$ptr->alias} ON {$ptr->alias}.$leftJoin = {$ptr->parent->alias}.$rightJoin") ;
			$ptr = $ptr->child ;
		}
		return implode($list," JOIN  ") ;
	}
	
	public function __toString() {
		return "Entity name:{$this->name}, alias:{$this->alias}, " ;
	}
	
	
	//
	private function getLeftJoin() {
		return $this->joinCondition->getLeftJoin() ;
	}

	private function getRightJoin() {
		return $this->joinCondition->getRightJoin() ;
		
	}
	
	
	private function addChild($child) {
		$this->child = $child ;
	}
	
	
	
	
}
?>