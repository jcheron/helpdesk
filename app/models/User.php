<?php
/**
 * Représente un utilisateur
 * @author jcheron
 * @version 1.1
 * @package helpdesk.models
 */
class User extends Base{
	/**
	 * @Id
	 */
	private $id;
	private $login="";
	private $password="";
	private $mail="";
	private $admin=false;
	private $key;

	/**
	 * @ManyToOne
	 * @JoinColumn(name="idAuthProvider",className="AuthProvider",nullable=true)
	 */
	private $authProvider;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id=$id;
		return $this;
	}

	public function getLogin() {
		return $this->login;
	}

	public function setLogin($login) {
		$this->login=$login;
		return $this;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password=$password;
		return $this;
	}

	public function getMail() {
		return $this->mail;
	}

	public function setMail($mail) {
		$this->mail=$mail;
		return $this;
	}

	public function getAdmin() {
		return $this->admin;
	}

	public function setAdmin($admin) {
		$this->admin=$admin;
		return $this;
	}

	public function toString(){
		$uType="Utilisateur";
		$p="";
		if($this->admin){
			$uType="Administrateur";
		}
		if($this->authProvider!=null){
			$p="<span class='".$this->authProvider->getIcon()."' aria-hidden='true'></span>&nbsp;";
		}
		return $p.$this->mail. "-".$this->login." (".$uType.")";
	}

	public function getKey() {
		return $this->key;
	}

	public function setKey($key) {
		$this->key=$key;
		return $this;
	}

	public function getAuthProvider() {
		return $this->authProvider;
	}

	public function setAuthProvider($authProvider) {
		$this->authProvider=$authProvider;
		return $this;
	}


}