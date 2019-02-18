<?php

require '../vendor/autoload.php'; 
require 'SpringUpdateInf.php' ;

use Minime\Annotations\Reader;
use Minime\Annotations\Parser;
use Minime\Annotations\Cache\ArrayCache;

abstract class EntityReflection implements SpringUpdateInf {

	const ANNO_PRIMARY	=	'primary' ;
	const ANNO_COLUMN	=	'column' ;
	const ANNO_JOIN		=	'join' ;
	
	private $_reflection ;
	private $_mapping = array() ;
	private $_join = array() ;
	private $_primaryColumnName ;
	private $_entityName ;
	private $_className ;
	
	function __construct() {
		
		
		$this->_reflection = new ReflectionClass($this) ;
		
		$this->_mapping = array() ;
		$this->_join = array() ;
		
		$_reader = new Reader(new Parser, new ArrayCache);

		$this->_className = $this->_reflection->getName() ;
		$this->_entityName  = $_reader->getClassAnnotations($this->_className)->get('entity') ;
		
		if ($this->_entityName == null){
			$this->_entityName = strtolower($_className) ;
		 	throw new Exception("Entity annotation is missing - expecting  @entity on main class -") ;
		}
		
		foreach ($this->_reflection->getProperties() as $key => $refProperty) {
			
			$propertyName 	= 	$refProperty->getName() ;
			$className		=	$refProperty->getDeclaringClass()->getName() ;
			$propertyAnnotations = $_reader->getPropertyAnnotations($className,$propertyName) ;
			
			
			foreach($propertyAnnotations as $annotation=>$annotationValue) {
	
					if ($annotation == self::ANNO_PRIMARY) {
						
						$this->addMappingColumnNameToIdName($annotationValue,$propertyName) ;
						$this->setPrimaryColumName($annotationValue) ;
					
					} else if ($annotation == self::ANNO_COLUMN) {
						
						$this->addMappingColumnNameToIdName($annotationValue,$propertyName) ;
					
					} else if ($annotation == self::ANNO_JOIN) {
						echo "JOIN -------->".$annotationValue."\n";
						
						$this->addJoinToIdName($annotationValue,$propertyName) ;
						// @TODO ClassName.instancePropertyName,localColumnName

						$joinFunction = split(',',$annotionValue) ;
						split('.',$joinFunction[0]) ;
						
						preg_match('/([A-Za-z])/',$matches,PREG_OFFSET_CAPTURE)
						
						$inst = $this->createInstanceFromClassName($className) ;				//
						
						$property = $this->_reflection->getProperty($propertyName) ;
						$property->setAccessible(true) ;
						$property->setValue($this,$inst);
						
						
					}
			}
			
			
		}
		
	}
	
	private function createInstanceFromClassName($className) {
		$_reflection = new ReflectionClass($className) ;
		$inst = $_reflection->newInstanceWithoutConstructor();
	    $inst->__construct() ;
		return $inst ;
	}
	
	function buildConditionStatement($level = 0) {
		
	}
	
	public function get($columnId) {
		$propertyName = $this->mapColumnNameToPropertyName($columnId) ;
		$property = $this->_reflection->getProperty($propertyName) ;
		$property->setAccessible(true) ;
		return $property->getValue($this) ;

	}

	public function set($columnId,$value) {
		$propertyName = $this->mapColumnNameToPropertyName($columnId) ;
		$property = $this->_reflection->getProperty($propertyName) ;
		$property->setAccessible(true) ;
		$property->setValue($this,$value);
	}
	

	private function mapColumnNameToPropertyName($columnName) {
		return $this->_mapping[$columnName] == null ? $columnName : $this->_mapping[$columnName] ;
	}
	
	private function addMappingColumnNameToIdName($columnName,$idName) {
		$this->_mapping[$columnName] = $idName ;
	}	
	
	private function addJoinToIdName($annotation,$propertyName) {
			echo "addJoin $annotation --> $propertyName\n" ;
			$this->_join[$propertyName] = $annotation ;
	}	
	
	private function setPrimaryColumName($columnName) {
		$this->_primaryColumnName = $columnName ;
	}

	public function getPrimaryIdColumnName() {
		return $this->_primaryColumnName ;
	}



	



	public function buildJoins() {
		
	}
	
	
	// Building up SQL Statements

	private function buildJoinAlias($aliasName,$joinId,$entity,$enityId) {
		return  "JOIN a_$aliasName ON a_$aliasName.$joinId = e_$entity.$entityId ";
	}

	private function buildJoinsStatement() {
		return"" ;
	}
	

	private function buildEntityColumnsFromKeys($entAlias,$keys) {
		$nk = array() ;
		
		foreach($keys as $index => $value) {
			array_push($nk,$entAlias.".".$value." as $value") ;
		}
		return $nk ;
	}

	private function buildEntityAlias() {
		return  "e_".$this->_entityName ;
	}

	private function buildFromStatement() {
		return "FROM ".$this->_entityName." as e_".$this->_entityName." " ;
	}
	private function buildWhereStatement() {
		return " WHERE ".$this->buildEntityAlias().".".$this->_primaryColumnName." = '".$this->get($this->mapColumnNameToPropertyName($this->_primaryColumnName))."'" ;
	}
	private function buildDeleteStatement() {
		$deleteStatement = "DELETE ".$this->buildFromStatement().$this->buildWhereStatement() ;
		return $deleteStatement ;
	}

	private function buildInsertStatement() {

	}
	
	private function buildUpdateStatement() {
		
	}

	public function buildSelectStatement() {
		var_dump($this->buildFromStatement()) ;
		$entColumns  = $this->buildEntityColumnsFromKeys($this->buildEntityAlias(),array_keys ( $this->_mapping )) ;
		
		var_dump(implode(',',$entColumns)) ;
		var_dump(implode('#',array_keys ( $this->_join))) ;
		var_dump($this->buildFromStatement().$this->buildJoinsStatement().$this->buildWhereStatement()) ;
		
				
	}
	
	public function delete() {
		$statement = $this->buildDeleteStatement() ; 
		echo $statement."\n" ;
		
	}
	
	public function insert() {
		
	}
	
	public function update() {
		
	}
	
}

?>
