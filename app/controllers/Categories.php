<?php
/**
 * Gestion des catégories
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */
class Categories extends \_DefaultController {

	public function Categories(){
		parent::__construct();
		$this->title="Catégories";
		$this->model="Categorie";
	}

	public function frm($id=NULL){
		$object=$this->getInstance($id);
		$categories=DAO::getAll("Categorie");
		$idParent=-1;
		if(null!==$object->getCategorie()){
			$idParent=$object->getCategorie()->getId();
		}
		$list=Gui::select($categories,$idParent,"Sélectionner une catégorie parente...");
		$this->loadView("categorie/vAdd",array("select"=>$list,"categorie"=>$object));
	}

	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		if(isset($_POST["idCategorie"])){
			$parent=DAO::getOne("Categorie", $_POST["idCategorie"]);
			$object->setCategorie($parent);
		}

	}
}