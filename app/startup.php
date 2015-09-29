<?php
use micro\orm\DAO;
use micro\utils\StrUtils;
use micro\controllers\Autoloader;
error_reporting(E_ALL);
?>

<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);
$config=include_once ROOT.DS.'config.php';

require_once ROOT.'micro/log/Logger.php';
require_once ROOT.'micro/controllers/Autoloader.php';

Autoloader::register();

$ctrl=new Startup();
$ctrl->run();

class Startup{
	private $urlParts;
	public function run(){
		global $config;
		session_start();
		Logger::init();
		if($config["test"]){
			$config["siteUrl"]="http://127.0.0.1:8090/";
		}
		extract($config["database"]);
		$db=$config["database"];
		DAO::connect($db["dbName"],@$db["serverName"],@$db["port"],@$db["user"],@$db["password"]);
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
				}catch (\Exception $e){
					print "Error!: " . $e->getMessage() . "<br/>";
					die();
				}
			}catch (\Exception $e){
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