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

	public function ckEditorSample(){
		$this->loadView("main/vHeader");
		echo "<div class='container'>";
		echo "<h1>Exemple ckEditor</h1>";
		echo "<textarea id='editor1'>Exemple de <strong>contenu</strong></textarea>";
		echo JsUtils::execute("CKEDITOR.replace( 'editor1');");
		echo "</div>";
		$this->loadView("main/vFooter");
	}
}