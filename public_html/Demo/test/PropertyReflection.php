<?php
require '../vendor/autoload.php'; 
require 'DLogger.php' ;
require 'JoinAnnotation.php' ;

use Minime\Annotations\Reader;
use Minime\Annotations\Parser;
use Minime\Annotations\Cache\ArrayCache;

class PropertyReflection  {

	const ANNO_PRIMARY	=	'primary' ;
	const ANNO_COLUMN	=	'column' ;
	const ANNO_JOIN		=	'join' ;
	
	public static $_log  = 'PropertyReflection';
 	
	
	private $_reflection ;
	private $_mapping = array() ;
	private $_join = array() ;
	private $_primaryColumnName ;
	private $_entityName ;
	private $_className ;
	
	
	function __construct() {
			
		
	}
	
	// Reflect on a Class Name (String) or an actual instance.
	
	public function reflect($object)	{
		
		$this->_reflection = new ReflectionClass($object) ;
		
		$_reader = new Reader(new Parser, new ArrayCache);

		$this->_className = $this->_reflection->getName() ;
		self::logger("Reflect on Object/Class '{$this->_className}'") ;
		
		
		$this->_entityName  = $_reader->getClassAnnotations($this->_className)->get('entity') ;
		
		if ($this->_entityName == null){
//			$this->_entityName = strtolower($_className) ;
		 	throw new Exception("Entity annotation is missing - expecting  @entity on main class -") ;
		}

		self::logger("ClassName {$this->_className}") ;
		self::logger("EntityName {$this->_entityName}") ;

		foreach ($this->_reflection->getProperties() as $key => $refProperty) {
			
			$propertyName 	= 	$refProperty->getName() ;
			$className		=	$refProperty->getDeclaringClass()->getName() ;
			self::logger("************** getDeclaringClass = $className") ;
			$propertyAnnotations = $_reader->getPropertyAnnotations($className,$propertyName) ;
			
			// try and get value if this ($object) is an actual instance
			$property = $this->_reflection->getProperty($propertyName) ;
			$property->setAccessible(true) ;
			$propValue = (is_string($object) ? null : $property->getValue($object)) ;
			
			self::logger("ClassName $className PropertyName '$propertyName' PropValue = '$propValue' is Null ".(($propValue == null) ? 'true' : 'false'));
			
			
			// Now go through annotations -
			
			foreach ($propertyAnnotations as $annotation => $annotationValue) {
				
				self::logger("Annotation Parse annotation = '$annotation' value = '$annotationValue'\n") ;

				switch($annotation) {

					case self::ANNO_JOIN:
						self::logger("Annotation JOIN '$annotationValue' propertyName:$propertyName propertyValue:$propValue") ;

						$joinAnnotation = new JoinAnnotation($propertyName,$annotationValue,$propValue) ;
						$ref = new PropertyReflection() ;						
						$ref->reflect($propValue == null ?  $joinAnnotation->getClassName() : $propValue) ;
						break ;

					case self::ANNO_COLUMN:
						self::logger("Annotation COLUMN '$annotationValue' propertyName:$propertyName propertyValue:$propValue") ;
						break ;
						
					case self::ANNO_PRIMARY:
						self::logger("Annotation PRIMARY '$annotationValue' propertyName:$propertyName propertyValue:$propValue") ;
						break ;

					default:
				 		//throw new Exception("Unrecognised annotation $annotation") ;
						//warning('Unrecognised annotation $annotation') ;
						break ;
					
				} // switch
			} // foreach annotations
			self::logger("Completed annotations ($className)") ;			
		}
		self::logger("Completed properties ($className)") ;			
		
		
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
	
	static public function logger($str) {
		DLogger::logger(__CLASS__,$str,'INFO') ;
	}

}

?>
