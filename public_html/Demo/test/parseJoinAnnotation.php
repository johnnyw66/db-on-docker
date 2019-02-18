<?php
	require 'EntityAnnotationException.php' ;
	
	class JoinAnnotation {
		// Eg. 'Avatar.id,avatarId'  (Produces ON @entity value(Avatar.class), Avatar.@Column(fieldName))
		CONST pattern = '/(\w+).(\w+)\s*,\s*(\w+)/' ;

	   	private $matches ;
		private $className ;
		private $propetyName ;
		private $propetyValue ;
		
		function __construct($propertyName,$annotation,$propertyValue) {
			preg_match(self::pattern,$annotation,$this->matches, PREG_OFFSET_CAPTURE) ;
			throw new EntityAnnotationException("Invalid @join annotation - format should be '@join ClassName.keyId,foreignKeyId'") ;

			$this->propertyName = $propertyName ;
			$this->propertyValue = $propertyValue ;
			
		}
		
		public function getMatches() {
			return $this->matches ;
		}
		
		private function parseClass() {
			$_reflection = new ReflectionClass($this->className) ;
			$object = $_reflection->newInstanceWithoutConstructor();
		    $object->__construct() ;
			
		}
	}

	
//	$a= new JoinAnnotation('xxxx','Avatar.id,avatarId',null) ;
//	var_dump($a->getMatches()) ;
	
	
?>


