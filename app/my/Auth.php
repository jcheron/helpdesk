<?php
class Auth {
	public static function getUser(){
		return $_SESSION["user"];
	}

	public static function isAdmin(){
		$user=self::getUser();
		if($user instanceof User){
			return $user->getAdmin();
		}else{
			return false;
		}
	}
}