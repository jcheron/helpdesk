<?php

abstract class BaseController {
	abstract function index();
	public function __construct(){
		if(!$this->isValid())
			$this->onInvalidControl();
	}

	public function initialize(){

	}

	public function finalize(){

	}

	public function loadView($viewName,$pData="",$asString=false){
		global $config;
		if(is_array($pData)){
			extract($pData);
		}else{
			$data=$pData;
		}
		$fileName="views/".$viewName.".php";
		if(file_exists($fileName)){
			if($asString)
				return $this->includeFileAsString($fileName);
			else
				include($fileName);
		}else{
			throw new Exception("Vue inexistante");
		}
	}
	private function includeFileAsString($file){
		ob_start();
		include $file;
		return ob_get_clean();
	}

	/**
	 * retourne Vrai si l'accès au contrôleur est autorisé
	 * @return boolean
	 */
	public function isValid(){
			return true;
	}

	public function onInvalidControl(){
		header('HTTP/1.1 401 Unauthorized', true, 401);
		exit;
	}

	public function redirect($url){
		global $config;
		if(!StrUtils::startswith($url, $config["siteUrl"])){
			$url=$config["siteUrl"].$url;
		}
		header("location : ".$url);
	}
}
?>
