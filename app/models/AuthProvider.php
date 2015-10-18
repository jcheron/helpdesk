<?php
/**
 * Représente un provider externe pour connexion à l'application
 * @author jcheron
 * @version 1.1
 * @package helpdesk.models
 */

/**
 * @Table(name="authprovider")
 * @author jc
 *
 */
class AuthProvider extends Base{
	/**
	 * @Id
	 */
	private $id;
	private $name;
	private $icon;


	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id=$id;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name=$name;
		return $this;
	}

	/* (non-PHPdoc)
	 * @see Base::toString()
	 */
	public function toString() {
		return $this->name;

	}

	public function getIcon() {
		return $this->icon;
	}

	public function setIcon($icon) {
		$this->icon=$icon;
		return $this;
	}



}