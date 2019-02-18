<?php

class EntityProperty {

	private $idname ;
	private $value ;
	private $column ;
	private $reference ;
	
	function __construct($name,$value,$column,$reference) {
		$this->idname = $name ;
		$this->value = $value ;
		$this->column = $column ;
		$this->reference = $reference ;
	}

	public function getIdName() {
		return $this->idname ;
	}

	public function getColumnName() {
		return $this->column ;
	}
	
	public function getPropertyValue() {
		return $this->value ;
	}
	
	
	public function __toString() {
		return __CLASS__." {$this->idname}, {$this->value}, {$this->column} reference <{$this->reference}>" ;
	}
	

}
?>