<?php
class DefaultC extends \BaseController {

	public function index() {
		$this->loadView("main/vHeader");
		$this->loadView("main/vDefault");
		$this->loadView("main/vFooter");
	}

	public function asAdmin(){
		$_SESSION["user"]=DAO::getOne("User", "admin=1");
		$this->index();
	}

	public function asUser(){
		$_SESSION["user"]=DAO::getOne("User", "admin=0");
		$this->index();
	}

	public function disconnect(){
		$_SESSION = array();
		$this->index();
	}
}