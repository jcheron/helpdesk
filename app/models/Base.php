<?php
/**
 * Classe de base des models
 * @author jcheron
 * @version 1.1
 * @package helpdesk.models
 */
abstract class Base {
	public function __toString(){
		return $this->toString();
	}
	abstract public function toString();
}