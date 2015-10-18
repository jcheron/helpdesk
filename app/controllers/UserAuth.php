<?php
use micro\controllers\BaseController;
use micro\utils\RequestUtils;
use micro\orm\DAO;
use micro\js\Jquery;

class UserAuth extends BaseController {
	/* (non-PHPdoc)
	 * @see \micro\controllers\BaseController::index()
	 */
	public function index() {
		// TODO: Auto-generated method stub

	}

	function hybridauth_endpoint() {
		include "./../vendor/hybridauth/hybridauth/hybridauth/index.php";
	}

	function signin_with_hybridauth($provider) {
		$authConfig="./hybridauth/config.php";
		include "./../vendor/hybridauth/hybridauth/hybridauth/Hybrid/Auth.php";

		$hybridauth=new Hybrid_Auth($authConfig);
		$adapter=$hybridauth->authenticate($provider[0]);
		$user_profile=$adapter->getUserProfile();

		$dbProvider=DAO::getOne("AuthProvider", array (
				"name" => $provider[0]
		));
		if ($dbProvider!=NULL) {
			$user=DAO::getOne("User", array (
					"login" => $user_profile->displayName,"idAuthProvider" => $dbProvider->getId()
			));
			if ($user===null) {
				$user=new User();
				$user->setLogin($user_profile->displayName);
				$user->setMail($user_profile->email);
				$user->setAuthProvider($dbProvider);
				$user->setKey($user_profile->identifier);
				DAO::insert($user);
			}
			$_SESSION["user"]=$user;
			setcookie("autoConnect", $provider[0], time()+3600, "/");
			if (array_key_exists("action", $_SESSION)) {
				Startup::runAction($_SESSION["action"], false, false);
				unset($_SESSION["action"]);
			} else {
				echo '<h3>Connecté à '.$dbProvider->getName().'</h3>';
				echo '<h4>'.$user->getLogin().'</h4>';
				echo '<div class="row"><div class="col-xs-6 col-md-3"><img style="width: 230px;height:230px;border-radius: 6px;" src="'.$user_profile->photoURL.'&s=460" alt="avatar" width="230" height="230"></div></div>';
			}
			echo Jquery::get("DefaultC/getInfoUser/", "#divInfoUser");
		}
	}

		/*
	 * (non-PHPdoc)
	 * @see BaseController::initialize()
	 */
	public function initialize() {
		if (!RequestUtils::isAjax()) {
			ob_start();
			$this->loadView("main/vHeader", array (
					"infoUser" => Auth::getInfoUser()
			));
			echo "<div class='container'>";
			echo "<h1>Connexion</h1>";
		}
	}

	/*
	 * (non-PHPdoc)
	 * @see BaseController::finalize()
	 */
	public function finalize() {
		if (!RequestUtils::isAjax()) {
			echo "</div>";
			$this->loadView("main/vFooter");
			$all=ob_get_contents();
			ob_end_clean();
			echo $all;
		}
	}

	public function _showMessage($message, $type="success", $timerInterval=0, $dismissable=true, $visible=true) {
		$this->loadView("main/vInfo", array (
				"message" => $message,"type" => $type,"dismissable" => $dismissable,"timerInterval" => $timerInterval,"visible" => $visible
		));
	}
}