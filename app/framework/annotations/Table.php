<?php
/** @Target("class") */
class Table extends Annotation{
	public $name;
	public function checkConstraints($target){
		if(is_null($this->name))
			throw new Exception("L'attribut name est obligatoire pour une annotation de type Table");
	}
}