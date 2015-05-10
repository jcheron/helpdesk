<?php
require_once 'framework/log/chromePhp.php';

class Logger{
	public static function init(){
		ChromePhp::getInstance()->addSetting(ChromePhp::BACKTRACE_LEVEL, 2);
	}
	public static function log($id,$message){
		ChromePhp::log($id.":".$message);
	}
	public static function warn($id,$message){
		ChromePhp::warn($id.":".$message);
	}
	public static function error($id,$message){
		ChromePhp::error($id.":".$message);
	}
}