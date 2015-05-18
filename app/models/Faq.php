<?php
/**
 * Représente un article de la Faq
 * @author jcheron
 * @version 1.1
 * @package helpdesk.models
 */
class Faq extends Base{
	/**
	 * @Id
	 */
	private $id;
	private $titre;
	private $contenu;
	private $dateCreation;
	private $popularity;
	/**
	 * @ManyToOne
	 * @JoinColumn(name="idCategorie",className="Categorie",nullable=true)
	 */
	private $categorie;

	/**
	 * @ManyToOne
	 * @JoinColumn(name="idUser",className="User",nullable=false)
	 */
	private $user;
	private $version;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id=$id;
		return $this;
	}

	public function getTitre() {
		return $this->titre;
	}

	public function setTitre($titre) {
		$this->titre=$titre;
		return $this;
	}

	public function getContenu() {
		return $this->contenu;
	}

	public function setContenu($contenu) {
		$this->contenu=$contenu;
		return $this;
	}

	public function getDateCreation() {
		return $this->dateCreation;
	}

	public function setDateCreation($dateCreation) {
		$this->dateCreation=$dateCreation;
		return $this;
	}

	public function getCategorie() {
		return $this->categorie;
	}

	public function setCategorie($categorie) {
		$this->categorie=$categorie;
		return $this;
	}

	public function getUser() {
		return $this->user;
	}

	public function setUser($user) {
		$this->user=$user;
		return $this;
	}

	public function getVersion() {
		return $this->version;
	}

	public function setVersion($version) {
		$this->version=$version;
		return $this;
	}

	public function toString(){
		return $this->titre." - ".$this->user;
	}

	public function getPopularity() {
		return $this->popularity;
	}

	public function setPopularity($popularity) {
		$this->popularity=$popularity;
		return $this;
	}


}