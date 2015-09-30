<?php

use micro\controllers\Autoloader;
ini_set('display_errors',1);
error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS."../app/");
$config=include_once ROOT.DS.'config.php';

require_once ROOT.'micro/log/Logger.php';
require_once ROOT.'micro/controllers/Autoloader.php';
Autoloader::register();

include __DIR__ . "/../vendor/autoload.php";
include __DIR__ . "/support/WebDriverAssertions.php";
include __DIR__ . "/support/WebDriverDevelop.php";

