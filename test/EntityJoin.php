<?php

class EntityJoin {

	private $leftColumnName ;
	private $rightColumnName ;
	
	function __construct($leftColumnName,$rightColumnName) {
		$this->leftColumnName = $leftColumnName ;
		$this->rightColumnName = $rightColumnName ;
	}

	public function getLeftJoin() {
		return $this->leftColumnName ;
	}

	public function getRightJoin() {
		return $this->rightColumnName ;
	}
	
	
	
	public function __toString() {
		return __CLASS__." {$this->leftColumnName}, {$this->rightColumnName}" ;
	}
	

}
?>