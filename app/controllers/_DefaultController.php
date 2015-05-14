<?php
class _DefaultController extends \BaseController {
	protected $className;
	protected $baseHref;
	protected $title;

	public function index(){
		global $config;
		$objects=DAO::getAll($this->className);
		echo "<table class='table table-striped'>";
		echo "<thead><tr><th>".$this->className."</th></tr></thead>";
		echo "<tbody>";
		foreach ($objects as $object){
			echo "<tr>";
			echo "<td>".$object->toString()."</td>";
			echo "<td class='td-center'><a class='btn btn-primary btn-xs' href='".$this->baseHref."/frm/".$object->getId()."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>".
			"<td class='td-center'><a class='btn btn-warning btn-xs' href='".$this->baseHref."/delete/".$object->getId()."'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a class='btn btn-primary' href='".$config["siteUrl"].get_class($this)."/frm'>Ajouter...</a>";
	}

	public function frm($id=NULL){
		if(isset($id)){
			$object=DAO::getOne($this->className, $id[0]);
		}else{
			$className=$this->className;
			$object=new $className();
		}
		return $object;
	}
	protected function setValuesToObject(&$object){
		RequestUtils::setValuesToObject($object,$_POST);
	}
	public function update(){
		if(RequestUtils::isPost()){
			$className=$this->className;
			$object=new $className();
			$this->setValuesToObject($object);
			if($_POST["id"]){
				try{
					DAO::update($object);
					$this->messageSuccess($this->className." `{$object->toString()}` mis à jour");
				}catch(Exception $e){
					$this->messageDanger("Impossible de modifier l'instance de ".$this->className);
				}
			}else{
				try{
					DAO::insert($object);
					$this->messageSuccess("Instance de ".$this->className." `{$object->toString()}` ajoutée");
				}catch(Exception $e){
					$this->messageDanger("Impossible d'ajouter l'instance de ".$this->className);
				}
			}
		}
	}

	public function delete($id){
		try{
			$object=DAO::getOne($this->className, $id[0]);
			if($object!==NULL){
				DAO::delete($object);
				$this->messageSuccess($this->className." `{$object->toString()}` supprimé(e)");
			}else{
				$this->messageWarning($this->className." introuvable");
			}
		}catch(Exception $e){
			$this->messageDanger("Impossible de supprimer l'instance de ".$this->className);
		}
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

	public function _showMessage($message,$type="success"){
		global $config;
		$this->loadView("main/vInfo",array("message"=>$message,"href"=>$config["siteUrl"].$this->baseHref,"type"=>$type));
	}

	public function messageSuccess($message){
		$this->_showMessage($message);
	}

	public function messageWarning($message){
		$this->_showMessage($message,"warning");
	}

	public function messageDanger($message){
		$this->_showMessage($message,"danger");
	}
	public function messageInfo($message){
		$this->_showMessage($message,"info");
	}

}