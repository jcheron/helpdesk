<?php
class Categorie extends Base{
	/**
	 * @Id
	 */
	private $id;
	private $libelle;
	/**
	 * @ManyToOne
	 * @JoinColumn(name="idCategorie",className="Categorie",nullable=true)
	 */
	private $categorie;
	/**
	* @OneToMany(mappedBy="categorie",className="Categorie")
	*/
	private $categories;

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

	public function getCategorie() {
		return $this->categorie;
	}

	public function setCategorie($categorie) {
		$this->categorie=$categorie;
		return $this;
	}

	public function toString(){
		$parent="";
		if(isset($this->categorie))
			$parent=" (".$this->categorie.")";
		return $this->libelle.$parent;
	}

	public function getCategories() {
		return $this->categories;
	}

	public function setCategories($categories) {
		$this->categories=$categories;
		return $this;
	}

}