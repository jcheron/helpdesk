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

	public function forward($controller,$action="index",$params=array(),$initialize=false,$finalize=false){
		try{
			$obj=new $controller();
			if($initialize===true){
				$obj->initialize();
			}
			if(method_exists($obj, $action)){
				$obj->$action($params);
			}else{
				throw new Exception("La méthode `{$action}` n'existe pas sur le contrôleur `{$controller}`");
			}
			if($finalize===true){
				$obj->finalize();
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}
?>
