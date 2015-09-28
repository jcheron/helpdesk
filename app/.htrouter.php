<?php
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
	$_GET["c"]="";
	if (isset($_SERVER['QUERY_STRING'])) {
		$_GET["c"]=$_SERVER['QUERY_STRING'];
	}
    include __DIR__ . '/startup.php';
}