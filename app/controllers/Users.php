<?php
class Users extends \_DefaultController {

	public function Users(){
		$this->title="Utilisateurs";
		$this->model="User";
	}

	public function frm($id=NULL){
		$user=$this->getInstance($id);
		$this->loadView("user/vAdd",array("user"=>$user));
	}

	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		$object->setAdmin(isset($_POST["admin"]));
	}

	public function tickets(){
		$this->forward("tickets");
	}
}