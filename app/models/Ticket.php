<?php
/**
 * Représente un ticket
 * @author jcheron
 * @version 1.1
 * @package helpdesk.models
 */
class Ticket extends Base{
	/**
	 * @Id
	 */
	private $id;
	private $type;
	private $titre;
	private $description;
	private $dateCreation;
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

	/**
	 * @ManyToOne
	 * @JoinColumn(name="idStatut",className="Statut",nullable=false)
	 */
	private $statut;

	private $version;

	/**
	 * @OneToMany(mappedBy="ticket",className="Message")
	 */
	private $messages;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id=$id;
		return $this;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type=$type;
		return $this;
	}

	public function getTitre() {
		return $this->titre;
	}

	public function setTitre($titre) {
		$this->titre=$titre;
		return $this;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description=$description;
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

	public function getStatut() {
		return $this->statut;
	}

	public function setStatut($statut) {
		$this->statut=$statut;
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
		$cat="";
		if($this->categorie!==null)
			$cat=$this->categorie;
		$stat="";
		if($this->statut!==null)
			$stat=$this->statut;
		return $this->titre." - ".$cat." (".$stat.")";
	}

	public function getMessages() {
		return $this->messages;
	}

	public function setMessages($messages) {
		$this->messages=$messages;
		return $this;
	}


}