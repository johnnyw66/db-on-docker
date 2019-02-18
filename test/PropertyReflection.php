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
 		
	private $classVisited ;
	
	function __construct() {
		$this->classVisited = array() ;	
	}
	
	public function hasVisitedClass($name) {
		return in_array($name,$this->classVisited) ;
	}
	
	public function visitClass($name) {
		if (!$this->hasVisitedClass($name)) {
			array_push($this->classVisited,$name) ;
		}
	}
	
	// Reflect on a Class Name (String) or an actual instance.
	
	public function reflect($object)	{

		$_reader = new Reader(new Parser, new ArrayCache);
		$_reflection = new ReflectionClass($object) ;
		

		$_className = $_reflection->getName() ;
		self::logger("Reflect on Object/Class '{$_className}'") ;
		$this->visitClass($_className) ;
		
		$_entityName  = $_reader->getClassAnnotations($_className)->get('entity') ;
		
		if ($_entityName == null){
//			$_entityName = strtolower($_className) ;
		 	throw new Exception("Entity annotation is missing - expecting  @entity on main class -") ;
		}

		self::logger("ClassName {$_className} EntityName {$_entityName}") ;
		self::logger("Starting going through Properties...") ;
		
		foreach ($_reflection->getProperties() as $key => $refProperty) {
			
			$propertyName 	= 	$refProperty->getName() ;
			$className		=	$refProperty->getDeclaringClass()->getName() ;
			self::logger("************** getDeclaringClass = $className") ;
			$propertyAnnotations = $_reader->getPropertyAnnotations($className,$propertyName) ;
			
			// try and get value if this ($object) is an actual instance
			$property = $_reflection->getProperty($propertyName) ;
			$property->setAccessible(true) ;
			$propValue = (is_string($object) ? null : $property->getValue($object)) ;
			
			self::logger("ClassName $className PropertyName '$propertyName' PropValue = '$propValue' is Null ".(($propValue == null) ? 'true' : 'false'));
			self::logger("Starting going through Annotations...") ;
			
			
			// Now go through annotations -
			
			foreach ($propertyAnnotations as $annotation => $annotationValue) {
				
				self::logger("Annotation Parse annotation = '$annotation' value = '$annotationValue'\n") ;

				switch($annotation) {

					case self::ANNO_JOIN:
						self::logger("ANNOTATION JOIN '$annotationValue' propertyName:$propertyName propertyValue:$propValue") ;

						$joinAnnotation = new JoinAnnotation($propertyName,$annotationValue,$propValue) ;


						if ($this->hasVisitedClass($joinAnnotation->getClassName()) && $propValue == null) {
							echo("NOT ALLOWING RECURSIVE CALLS ON AN ALREADY VISITED ENITY WITHOUT AN EXPLICIT VALUE\n") ;
						} else {
							self::logger("\n\n\nReflect new class....\n\n\n");	
							$this->reflect($propValue == null ?  $joinAnnotation->getClassName() : $propValue) ;
							self::logger("Finish Reflection - 2 class:".$joinAnnotation->getClassName()."\n\n");						
						}					
						
						break ;

					case self::ANNO_COLUMN:
						self::logger("ANNOTATION COLUMN '$annotationValue' propertyName:$propertyName propertyValue:$propValue") ;
						break ;
						
					case self::ANNO_PRIMARY:
						self::logger("ANNOTATION PRIMARY '$annotationValue' propertyName:$propertyName propertyValue:$propValue") ;
						break ;

					default:
				 		//throw new Exception("Unrecognised annotation $annotation") ;
						//warning('Unrecognised annotation $annotation') ;
						break ;
					
				} // switch
			} // foreach annotations
			self::logger("Completed annotations ($className)") ;			
		}
//		self::logger("Completed properties ($className)") ;			
		
		self::logger("Finish Reflection - 1 class:($className)\n\n");						
		
	}
	
	/*
	public function get($columnId) {
		$propertyName = $mapColumnNameToPropertyName($columnId) ;
		$property = $_reflection->getProperty($propertyName) ;
		$property->setAccessible(true) ;
		return $property->getValue($this) ;

	}

	public function set($columnId,$value) {
		$propertyName = $mapColumnNameToPropertyName($columnId) ;
		$property = $_reflection->getProperty($propertyName) ;
		$property->setAccessible(true) ;
		$property->setValue($this,$value);
	}
	*/
	
	static public function logger($str) {
		DLogger::logger(__CLASS__,$str,'INFO') ;
	}

}

?>
