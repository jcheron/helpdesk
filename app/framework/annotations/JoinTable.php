<?php

/** @Target("property") */
class JoinTable extends Annotation{
	public $name;
	public $joinColumns;
	public $inverseJoinColumns;
	public function checkConstraints($target){
		parent::checkConstraints($target);
		if(is_null($this->name))
			throw new Exception("L'attribut name est obligatoire pour une annotation de type JoinTable");
	}

}