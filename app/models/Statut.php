<?php
class Statut extends Base{
	/**
	 * @Id
	 */
	private $id;
	private $libelle;
	private $ordre;
	private $icon;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id=$id;
		return $this;
	}

	public function getLibelle() {
		return $this->libelle;
	}

	public function setLibelle($libelle) {
		$this->libelle=$libelle;
		return $this;
	}

	public function getOrdre() {
		return $this->ordre;
	}

	public function setOrdre($ordre) {
		$this->ordre=$ordre;
		return $this;
	}

	public function toString(){
		return "<span class='glyphicon glyphicon-".$this->icon."' aria-hidden='true'></span>&nbsp;".$this->libelle;
	}

	public function getIcon() {
		return $this->icon;
	}

	public function setIcon($icon) {
		$this->icon=$icon;
		return $this;
	}

}