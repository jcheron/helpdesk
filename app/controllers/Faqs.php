<?php
use micro\orm\DAO;
/**
 * Gestion des articles de la Faq
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */
class Faqs extends \_DefaultController {
	public function Faqs(){
		parent::__construct();
		$this->title="Foire aux questions";
		$this->model="Faq";
	}

	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		$object->setUser(Auth::getUser());
		$categorie=DAO::getOne("Categorie", $_POST["idCategorie"]);
		$object->setCategorie($categorie);
	}

	public function test(){
		$faqs=DAO::getAll("Faq","1=1 order by dateCreation limit 1,1");
		foreach ($faqs as $faq){
			echo $faq."<br>";
		}
		echo DAO::$db->query("SELECT max(id) FROM Faq")->fetchColumn();
		$ArticleMax=DAO::getOne("Faq","id=(SELECT max(id) FROM Faq)");
		echo $ArticleMax;
	}
	
	public function index($params=null){
		global $config;
		$orderBy="";
		$baseHref=get_class($this);
		if(isset($params)){
			if(is_string($params)){
				$message=new DisplayedMessage($params);
			}elseif (is_array($params)){
				if(sizeof($params)>1)
					$orderBy="1=1 order by ".$params[1];
				else
					$message=new DisplayedMessage($params[0]);

			}
			if(isset($message)){
				$message->setTimerInterval($this->messageTimerInterval);
				$this->_showDisplayedMessage($message);
			}
		}
		
		
		$objects=DAO::getAll($this->model,$orderBy);
		echo "<table class='table table-striped'>";
		echo "<thead>";
			echo "<tr>";
				echo "<th>".$this->model."</th>";
				echo "<th>";
				echo "<div class='btn-group'>";
					echo "<button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>";
						echo "Trier par... <span class='caret'></span>";
					echo "</button>";
					echo "<ul class='dropdown-menu' role='menu'>";
						echo "<li><a href='Faqs'>Par categorie</a></li>";
					echo "</ul>";
				echo "</div>";
				echo "</th>";
			echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach ($objects as $object){
			echo "<tr>";
			echo "<td class='titre-faq'><a href='".$baseHref."/frm2/".$object->getId()."' style='color:#253939'><b>".$object->getTitre()."</b> - ".$object->getUser()."</a></td>";
			echo "<td class='td-center'><a class='btn btn-success btn-xs' href='".$baseHref."/frm2/".$object->getId()."'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a></td>";
			if (Auth::isAdmin()){
				echo "<td class='td-center'><a class='btn btn-primary btn-xs' href='".$baseHref."/frm/".$object->getId()."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>".
				"<td class='td-center'><a class='btn btn-warning btn-xs' href='".$baseHref."/delete/".$object->getId()."'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
			}
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		
		if (Auth::isAdmin()){
			echo "<a class='btn btn-primary' href='".$config["siteUrl"].$baseHref."/frm'>Ajouter...</a>";
		}
	}
	
	
	/* (non-PHPdoc)
	 * @see _DefaultController::frm()
	 */
	public function frm($id = NULL) {
		
		if (Auth::isAdmin()){
		$faq = $this->getInstance($id);
			if (isset($id)){
				$ajou_modif = "Modifier";
				$this->loadView("faq/vUpdateTitre",array("faq"=>$faq, "ajou_modif"=>$ajou_modif));
			}
			else {
				$ajou_modif = "Ajouter";
				$this->loadView("faq/vUpdateTitre",array("faq"=>$faq, "ajou_modif"=>$ajou_modif));
			}
		}
		else {
			echo "Vous devez vous connecter en tant qu'administrateur pour accéder à ce module";
		}
	}
	
	public function frm2($id = NULL) {
		$faq = $this->getInstance($id);
		$this->loadView("faq/vReadElent", array("faq"=>$faq));
	}
	
	public function trier(){
		
	}
	
	
	
	
	
}