<?php
use micro\controllers\BaseController;
use micro\utils\RequestUtils;
class Selenium extends BaseController {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->initialize();
		echo "<h1>Hello Selenium</h1>";
		echo "<form method='POST' action='/Selenium/post' name='frm' id='frm'>";
		echo "<input type='text' name='text' id='text'>";
	}
	public function post(){
		if(RequestUtils::isPost()){
			echo "<div id='result'>".$_POST['text']."</div>";
		}
	}
}