<?php
class Users extends \_DefaultController {

	public function Users(){
		$this->baseHref="users";
		$this->title="Utilisateurs";
		$this->className="User";
	}

	public function frm($id=NULL){
		$user=new User();
		if(isset($id) && sizeof($id)>0){
			$user=DAO::getOne("User", $id[0]);
		}
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