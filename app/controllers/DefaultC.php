<?php
/**
 * Contrôleur par défaut (défini dans config => documentRoot)
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */
class DefaultC extends \BaseController {

	/**
	 * Affiche la page par défaut du site
	 * @see BaseController::index()
	 */
	public function index() {
		$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
		$this->loadView("main/vDefault");
		$this->loadView("main/vFooter");
	}

	/**
	 * Affiche la page de test
	 */
	public function test() {
		$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
		$this->loadView("main/vTest");
		$this->loadView("main/vFooter");
	}
	/**
	 * Connecte le premier administrateur trouvé dans la BDD
	 */
	public function asAdmin(){
		$_SESSION["user"]=DAO::getOne("User", "admin=1");
		$_SESSION['KCFINDER'] = array(
				'disabled' => false
		);
		$this->index();
	}

	/**
	 * Connecte le premier utilisateur (non admin) trouvé dans la BDD
	 */
	public function asUser(){
		$_SESSION["user"]=DAO::getOne("User", "admin=0");
		$_SESSION['KCFINDER'] = array(
				'disabled' => true
		);
		$this->index();
	}

	/**
	 * Déconnecte l'utilisateur actuel
	 */
	public function disconnect(){
		$_SESSION = array();
		$_SESSION['KCFINDER'] = array(
				'disabled' => true
		);
		$this->index();
	}

	public function ckEditorSample(){
		$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
		echo "<div class='container'>";
		echo "<h1>Exemple ckEditor</h1>";
		echo "<textarea id='editor1'>Exemple de <strong>contenu</strong></textarea>";
		echo JsUtils::execute("CKEDITOR.replace( 'editor1');");
		echo "</div>";
		$this->loadView("main/vFooter");
	}
}