<?php
use micro\controllers\Startup;
use micro\controllers\Autoloader;
error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);
$config=include_once ROOT.DS.'config.php';
require_once ROOT.'micro/log/Logger.php';
require_once ROOT.'micro/controllers/Autoloader.php';
require_once ROOT.'./../vendor/autoload.php';

Autoloader::register();
$application=new Startup();
$application->run();