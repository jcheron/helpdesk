<?php
abstract class Base {
	public function __toString(){
		return $this->toString();
	}
	abstract public function toString();
}