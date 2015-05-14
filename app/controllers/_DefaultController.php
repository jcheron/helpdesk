<?php
class _DefaultController extends \BaseController {
	protected $model;
	protected $messageTimerInterval=5000;
	protected $title;

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

	public function getInstance($id=NULL){
		if(isset($id) && sizeof($id)>0){
			$object=DAO::getOne($this->model, $id[0]);
		}else{
			$className=$this->model;
			$object=new $className();
		}
		return $object;
	}

	public function frm($id=NULL){
		echo "Non implémenté...";
	}

	protected function setValuesToObject(&$object){
		RequestUtils::setValuesToObject($object,$_POST);
	}
	public function update(){
		if(RequestUtils::isPost()){
			$className=$this->model;
			$object=new $className();
			$this->setValuesToObject($object);
			if($_POST["id"]){
				try{
					DAO::update($object);
					$msg=new DisplayedMessage($this->model." `{$object->toString()}` mis à jour");
				}catch(Exception $e){
					$msg=new DisplayedMessage("Impossible de modifier l'instance de ".$this->model,"danger");
				}
			}else{
				try{
					DAO::insert($object);
					$msg=new DisplayedMessage("Instance de ".$this->model." `{$object->toString()}` ajoutée");
				}catch(Exception $e){
					$msg=new DisplayedMessage("Impossible d'ajouter l'instance de ".$this->model,"danger");
				}
			}
			$this->forward(get_class($this),"index",$msg);
		}
	}

	public function delete($id){
		try{
			$object=DAO::getOne($this->model, $id[0]);
			if($object!==NULL){
				DAO::delete($object);
				$msg=new DisplayedMessage($this->model." `{$object->toString()}` supprimé(e)");
			}else{
				$msg=new DisplayedMessage($this->model." introuvable","warning");
			}
		}catch(Exception $e){
			$msg=new DisplayedMessage("Impossible de supprimer l'instance de ".$this->model,"danger");
		}
		$this->forward(get_class($this),"index",$msg);
	}
	/* (non-PHPdoc)
	 * @see BaseController::initialize()
	 */
	public function initialize() {
		$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
		echo "<div class='container'>";
		echo "<h1>".$this->title."</h1>";
	}

	/* (non-PHPdoc)
	 * @see BaseController::finalize()
	 */
	public function finalize() {
		echo "</div>";
		$this->loadView("main/vFooter");
	}

	public function _showDisplayedMessage($message){
		$this->_showMessage($message->getContent(),$message->getType(),$message->getTimerInterval(),$message->getDismissable());
	}

	public function _showMessage($message,$type="success",$timerInterval=0,$dismissable=true){
		$this->loadView("main/vInfo",array("message"=>$message,"type"=>$type,"dismissable"=>$dismissable,"timerInterval"=>$timerInterval));
	}

	public function messageSuccess($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"success",$timerInterval,$dismissable);
	}

	public function messageWarning($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"warning",$timerInterval,$dismissable);
	}

	public function messageDanger($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"danger",$timerInterval,$dismissable);
	}
	public function messageInfo($message,$timerInterval=0,$dismissable=true){
		$this->_showMessage($message,"info",$timerInterval,$dismissable);
	}

}