<?php
use micro\orm\DAO;
use micro\utils\RequestUtils;
use micro\controllers\BaseController;
/**
 * Classe de base des contrôleurs Helpdesk
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */
class _DefaultController extends BaseController {
	/**
	 * @var string Classe du modèle associé
	 */
	protected $model;
	/**
	 * @var int durée en millisecondes d'affichage des messages d'information
	 */
	protected $messageTimerInterval=5000;
	/**
	 * @var string zone titre h1 de la page
	 */
	protected $title;

	/**
	 * Affiche la liste des instances de la class du modèle associé $model
	 * @see BaseController::index()
	 */
	public function index($message=null){
		global $config;
		$baseHref=get_class($this);
		if(isset($message)){
			if(is_string($message)){
				$message=new DisplayedMessage($message);
			}
			$message->setTimerInterval($this->messageTimerInterval);
			$this->_showDisplayedMessage($message);
		}
		$objects=DAO::getAll($this->model);
		echo "<table class='table table-striped'>";
		echo "<thead><tr><th>".$this->model."</th></tr></thead>";
		echo "<tbody>";
		foreach ($objects as $object){
			echo "<tr>";
			echo "<td>".$object->toString()."</td>";
			echo "<td class='td-center'><a class='btn btn-primary btn-xs' href='".$baseHref."/frm/".$object->getId()."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>".
			"<td class='td-center'><a class='btn btn-warning btn-xs' href='".$baseHref."/delete/".$object->getId()."'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a class='btn btn-primary' href='".$config["siteUrl"].$baseHref."/frm'>Ajouter...</a>";
	}

	/**
	 * Retourne une instance de $className<br>
	 * si $id est nul, un nouvel objet est retourné<br>
	 * sinon l'objet retourné est celui chargé depuis la BDD à partir de l'id $id
	 * @param string $id
	 * @return multitype:$className
	 */
	public function getInstance($id=NULL){
		if(isset($id) && sizeof($id)>0){
			$object=DAO::getOne($this->model, $id[0]);
		}else{
			$className=$this->model;
			$object=new $className();
		}
		return $object;
	}

	/**
	 * Affiche le formulaire d'ajout ou de modification d'une instance de $className<br>
	 * L'instance est définie à partir de $id<br>
	 * frm doit utiliser la méthode getInstance() pour obtenir l'instance à ajouter ou à modifier
	 * @see _DefaultController::getInstance()
	 * @param string $id
	 */
	public function frm($id=NULL){
		echo "Non implémenté...";
	}

	/**
	 * Affecte membre à membre les valeurs du tableau associatif $_POST aux membres de l'objet $object<br>
	 * Prévoir une sur-définition de la méthode pour l'affectation des membres de type objet<br>
	 * Cette méthode est utilisée update()
	 * @see _DefaultController::update()
	 * @param multitype:$className $object
	 */
	protected function setValuesToObject(&$object){
		RequestUtils::setValuesToObject($object,$_POST);
	}
	/**
	 * Met à jour à partir d'un post une instance de $className<br>
	 * L'affectation des membres de l'objet par le contenu du POST se fait par appel de la méthode setValuesToObject()
	 * @see _DefaultController::setValuesToObject()
	 */
	public function update(){
		if(RequestUtils::isPost()){
			$className=$this->model;
			$object=new $className();
			$this->setValuesToObject($object);
			if($_POST["id"]){
				try{
					DAO::update($object);
					$msg=new DisplayedMessage($this->model." `{$object->toString()}` mis à jour");
				}catch(\Exception $e){
					$msg=new DisplayedMessage("Impossible de modifier l'instance de ".$this->model,"danger");
				}
			}else{
				try{
					DAO::insert($object);
					$msg=new DisplayedMessage("Instance de ".$this->model." `{$object->toString()}` ajoutée");
				}catch(\Exception $e){
					$msg=new DisplayedMessage("Impossible d'ajouter l'instance de ".$this->model,"danger");
				}
			}
			$this->forward(get_class($this),"index",$msg);
		}
	}

	/**
	 * Supprime l'instance dont l'id est $id dans la BDD
	 * @param int $id
	 */
	public function delete($id){
		try{
			$object=DAO::getOne($this->model, $id[0]);
			if($object!==NULL){
				DAO::delete($object);
				$msg=new DisplayedMessage($this->model." `{$object->toString()}` supprimé(e)");
			}else{
				$msg=new DisplayedMessage($this->model." introuvable","warning");
			}
		}catch(\Exception $e){
			$msg=new DisplayedMessage("Impossible de supprimer l'instance de ".$this->model,"danger");
		}
		$this->forward(get_class($this),"index",$msg);
	}
	/* (non-PHPdoc)
	 * @see BaseController::initialize()
	 */
	public function initialize() {
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
			echo "<div class='container'>";
			echo "<h1>".$this->title."</h1>";
		}
	}

	/* (non-PHPdoc)
	 * @see BaseController::finalize()
	 */
	public function finalize() {
		if(!RequestUtils::isAjax()){
			echo "</div>";
			$this->loadView("main/vFooter");
		}
	}

	/**
	 * Affiche un message Alert bootstrap
	 * @param DisplayedMessage $message
	 */
	public function _showDisplayedMessage($message){
		$this->_showMessage($message->getContent(),$message->getType(),$message->getTimerInterval(),$message->getDismissable());
	}

	/**
	 * Affiche un message Alert bootstrap
	 * @param string $message texte du message
	 * @param string $type type du message (info, success, warning ou danger)
	 * @param number $timerInterval durée en millisecondes d'affichage du message (0 pour que le message reste affiché)
	 * @param string $dismissable si vrai, l'alert dispose d'une croix de fermeture
	 */
	public function _showMessage($message,$type="success",$timerInterval=0,$dismissable=true,$visible=true){
		$this->loadView("main/vInfo",array("message"=>$message,"type"=>$type,"dismissable"=>$dismissable,"timerInterval"=>$timerInterval,"visible"=>$visible));
	}

	/**
	 * Affiche un message Alert bootstrap de type success
	 * @param string $message texte du message
	 * @param number $timerInterval durée en millisecondes d'affichage du message (0 pour que le message reste affiché)
	 * @param string $dismissable si vrai, l'alert dispose d'une croix de fermeture
	 */
	public function messageSuccess($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"success",$timerInterval,$dismissable);
	}

	/**
	 * Affiche un message Alert bootstrap de type warning
	 * @param string $message texte du message
	 * @param number $timerInterval durée en millisecondes d'affichage du message (0 pour que le message reste affiché)
	 * @param string $dismissable si vrai, l'alert dispose d'une croix de fermeture
	 */
	public function messageWarning($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"warning",$timerInterval,$dismissable);
	}

	/**
	 * Affiche un message Alert bootstrap de type danger
	 * @param string $message texte du message
	 * @param number $timerInterval durée en millisecondes d'affichage du message (0 pour que le message reste affiché)
	 * @param string $dismissable si vrai, l'alert dispose d'une croix de fermeture
	 */
	public function messageDanger($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"danger",$timerInterval,$dismissable);
	}
	/**
	 * Affiche un message Alert bootstrap de type info
	 * @param string $message texte du message
	 * @param number $timerInterval durée en millisecondes d'affichage du message (0 pour que le message reste affiché)
	 * @param string $dismissable si vrai, l'alert dispose d'une croix de fermeture
	 */
	public function messageInfo($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"info",$timerInterval,$dismissable);
	}

}