<?php
require 'EntityAnnotationException.php' ;
	class JoinAnnotation {
		// Eg. 'Avatar.id,avatarId'  (Produces ON @entity value(Avatar.class), Avatar.@Column(fieldName))
		CONST pattern = '/(\w+).(\w+)\s*,\s*(\w+)/' ;


		private $propetyName ;

		private $propetyValue ;

		private $className ;
		private $keyIdname ;
		private $columnName ;
		
		function __construct($propertyName,$annotation,$propertyValue) {
			
			preg_match(self::pattern,$annotation,$matches, PREG_OFFSET_CAPTURE) ;

			if (count($matches) != 4) {
					throw new EntityAnnotationException("Invalid @join annotation ('$annotation')- format should be '@join ClassName.keyId,columnId'") ;
			}
			
			$this->propertyName = $propertyName ;
			$this->propertyValue = $propertyValue ;
			
			$this->className = $matches[1][0] ;
			$this->keyId = $matches[2][0] ;
			$this->columnName = $matches[3][0] ;
			//DLogger::logger(__CLASS__,$this,'INFO') ;
		}
		
		public function getMatches() {
			return $this->matches ;
		}
		
		private function parseClass() {
			$_reflection = new ReflectionClass($this->className) ;
			$object = $_reflection->newInstanceWithoutConstructor();
		    $object->__construct() ;
			
		}
		
		public function getClassName() {
			return $this->className ;
		}

		public function getKeyId() {
			return $this->keyId;		
		}
		
		public function getColumnName() {
			return $this->columnName ;
		}
		
		
		public function __toString() {
			return "className:{$this->className} keyId:{$this->keyId} columnName:{$this->columnName} propertyName:{$this->propertyName} propertyValue:{$this->propertyValue}" ;
		}		
		
	}
?>