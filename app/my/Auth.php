<?php
/**
 * Classe de gestion de l'authentification
 * @author jcheron
 * @version 1.1
 * @package helpdesk.my
 */
class Auth {
	/**
	 * Retourne l'utilisateur actuellement connecté<br>
	 * ou NULL si personne ne l'est
	 * @return User
	 */
	public static function getUser(){
		$user=null;
		if(array_key_exists("user", $_SESSION))
			$user=$_SESSION["user"];
		return $user;
	}

	/**
	 * Retourne vrai si un utilisateur est connecté
	 * @return boolean
	 */
	public static function isAuth(){
		return null!==self::getUser();
	}

	/**
	 * Retourne vrai si un utilisateur de type administrateur est connecté<br>
	 * Faux si l'utilisateur connecté n'est pas admin ou si personne n'est connecté
	 * @return boolean
	 */
	public static function isAdmin(){
		$user=self::getUser();
		if($user instanceof User){
			return $user->getAdmin();
		}else{
			return false;
		}
	}

	/**
	 * Retourne la zone d'information au format HTML affichant l'utilisateur connecté<br>
	 * ou les boutons de connexion si personne n'est connecté
	 * @return string
	 */
	public static function getInfoUser(){
		$user=self::getUser();
		if(isset($user)){
			$infoUser="<a class='btn btn-primary' href='defaultC/disconnect'>Déconnexion <span class='label label-success'>".$user."</span></a>";
		}else{
			$infoUser='<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								Connexion en tant que... <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="defaultC/asAdmin"><span class="glyphicon glyphicon-king" aria-hidden="true"></span>&nbsp;Administrateur</a></li>
								<li><a href="defaultC/asUser"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Utilisateur</a></li>
							</ul>
						</div>';
		}
		return $infoUser;
	}
}