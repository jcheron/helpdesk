<?php
class Categories extends \_DefaultController {

	public function Categories(){
		$this->baseHref="categories";
		$this->title="Catégories";
		$this->className="Categorie";
	}

	public function frm(){
		$categories=DAO::getAll("Categorie");
		$list=Gui::select($categories,-1,"Sélectionner une catégorie...");
		$this->loadView("categorie/vAdd",array("select"=>$list));
	}

	public function add(){
		$categorie=new Categorie();
		RequestUtils::setValuesToObject($categorie,$_POST);
		if(isset($_POST["idCategorie"])){
			$parent=DAO::getOne("Categorie", $_POST["idCategorie"]);
			$categorie->setCategorie($parent);
		}
	try{
		DAO::insert($categorie);
		$msg="Utilisateur `{$categorie->toString()}` ajoutée";
		$this->loadView("main/vInfo",array("message"=>$msg,"href"=>"categories","type"=>"success"));
	}catch(Exception $e){
		$this->loadView("main/vInfo",array("message"=>"Impossible d'insérer la catégorie","href"=>"categories","type"=>"danger"));
	}
	}
}