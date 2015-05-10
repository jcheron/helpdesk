<?php
error_reporting(E_ALL);
$config=include_once 'config.php';
$GLOBALS["siteUrl"]="/helpdesk/";
$GLOBALS["documentRoot"]="Test";
?>

<?php
require_once 'framework/log/Logger.php';

$ctrl=new Startup();
$ctrl->run();

function __autoload($myClass){
	global $config;
	if(file_exists("controllers/".$myClass.".php"))
		require_once("controllers/".$myClass.".php");
	else if(file_exists("models/".$myClass.".php"))
		require_once("models/".$myClass.".php");
	else if(file_exists("framework/".$myClass.".php"))
		require_once("framework/".$myClass.".php");
	else{
		foreach ($config["directories"] as $directory){
			if(file_exists($directory."/".$myClass.".php"))
				require_once($directory."/".$myClass.".php");
		}
	}
}
class Startup{
	private $urlParts;
	public function run(){
		global $config;
		session_start();
		Logger::init();
		extract($config["database"]);
		DAO::connect($dbName,@$serverName,@$port,@$user,@$password);
		$url=$_GET["c"];

		if(!$url){
			$url=$config["documentRoot"];
		}
		if(StrUtils::endswith($url, "/"))
			$url=substr($url, 0,strlen($url)-1);
		$this->urlParts=explode("/", $url);

		$u=$this->urlParts;
		$urlSize=sizeof($this->urlParts);

		if(class_exists($this->urlParts[0]) && StrUtils::startswith($this->urlParts[0],"_")===false){
			//Construction de l'instance de la classe (1er élément du tableau)
			try{
				$obj=new $this->urlParts[0]();
				$obj->initialize();
				try{
					switch ($urlSize) {
						case 1:
							$obj->index();
						break;
						case 2:
							//Appel de la méthode (2ème élément du tableau)
							if(method_exists($obj, $u[1])){
								$obj->$u[1]();
							}else{
								print "La méthode `{$u[1]}` n'existe pas sur le contrôleur `".$u[0]."`<br/>";
							}
							break;
						default:
							//Appel de la méthode en lui passant en paramètre le reste du tableau
							$obj->$u[1](array_slice($u, 2));
						break;
					}
				}catch (Exception $e){
					print "Error!: " . $e->getMessage() . "<br/>";
					die();
				}
			}catch (Exception $e){
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			$obj->finalize();
		}else{
			print "Le contrôleur `".$u[0]."` n'existe pas <br/>";
		}
	}
}
?>