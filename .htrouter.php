<?php
if (preg_match('/\.(?:png|jpg|jpeg|gif|ttf|eot|svg|woff|woff2|js|css)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
	$_GET["c"]=substr($_SERVER["REQUEST_URI"],1);
    include __DIR__ . '/app/indexTests.php';
}