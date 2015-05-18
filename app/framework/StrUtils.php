<?php
/**
 * Utilitaires liés aux chaînes
 * @author jc
 * @version 1.0.0.1
 * @package utils
 */
class StrUtils {
	public static function startswith($hay, $needle) {
		return substr($hay, 0, strlen($needle)) === $needle;
	}
	
	public static function endswith($hay, $needle) {
		return substr($hay, -strlen($needle)) === $needle;
	}
	
	public static function getBooleanStr($value){
		$ret="false";
		if($value)
			$ret="true";
		return $ret;
	}
}
?>
