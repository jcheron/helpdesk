<?php

/**
 * Utilitaires d'insertion de scripts côté client (JQuery)
 * @author jc
 * version 1.0.0.3
 */
class JsUtils {

	/**
	 * Ajoute les balises de Script avant et après le code si nécessaire
	 */
	private static function addScript($code){
		return preg_filter("/(\<script[^>]*?\>)?(.*)(\<\/script\>)?/si", "<script>$2 </script>\n", $code,1);
	}

	public static function addParam($parameter,$params){
		$params=preg_filter("/[\{]?([^\\}]*)[\}]?/si", "$1", $params,1);
		$values=explode(",", $params);
		$values[]=$parameter;
		return "{".implode(",", $values)."}";
	}
	/**
	 * Associe une fonction à l'évènement d'un élément DOM
	 */
	public static function bindToElement($element,$event,$function){
		return JsUtils::addScript("$('".$element."').bind('".$event."',".$function.");");
	}

	/**
	 * Exécute le script passé en paramètre
	 * @param String $script
	 * @return mixed
	 */
	public static function execute($script){
		return JsUtils::addScript($script);
	}

	public static function _get($url,$params="{}",$responseElement="",$function=NULL,$attr="id"){
		$function=isset($function)?$function:"";
		$retour="url='".$url."';\n";
		if($attr=="value")
			$retour.="url=url+'/'+$(this).val();\n";
		else
			$retour.="url=url+'/'+$(this).attr('".$attr."');\n";
		$retour.="$.get(url,".$params.").done(function( data ) {\n";
		if($responseElement!=="")
			$retour.="\t$('".$responseElement."').html( data );\n";
		$retour.="\t".$function."\n
		});\n";
		return $retour;
	}
	/**
	 * Effectue un GET en ajax
	 * @param string $url Adresse de la requête
	 * @param string $params Paramètres passés au format JSON
	 * @param string $responseElement id de l'élément HTML affichant la réponse
	 * @param string $function fonction appelée éventuellement après réception
	 */
	public static function get($url,$params="{}",$responseElement="",$function=NULL,$attr="id"){
		return JsUtils::addScript(JsUtils::_get($url,$params,$responseElement,$function));
	}

	public static function _post($url,$params="{}",$responseElement="",$function=NULL,$attr="id"){
		$function=isset($function)?$function:"";
		$retour="url='".$url."';\n";
		if($attr=="value")
			$retour.="url=url+'/'+$(this).val();\n";
		else
			$retour.="url=url+'/'+$(this).attr('".$attr."');\n";
		$retour.="$.post(url,".$params.").done(function( data ) {\n";
		if($responseElement!=="")
			$retour.="\t$('".$responseElement."').html( data );\n";
		$retour.="\t".$function."\n
		});\n";

		return $retour;
	}

	/**
	 * Effectue un POST en ajax
	 * @param string $url Adresse de la requête
	 * @param string $params Paramètres passés au format JSON
	 * @param string $responseElement id de l'élément HTML affichant la réponse
	 * @param string $function fonction appelée éventuellement après réception
	 */
	public static function post($url,$params="{}",$responseElement="",$function=NULL,$attr="id"){
				return JsUtils::addScript(JsUtils::_post($url,$params,$responseElement,$function));

	}

	public static function _postForm($url,$form,$responseElement,$validation=false,$function=NULL,$attr="id"){
		$function=isset($function)?$function:"";
		$retour="url='".$url."';\n";
		if($attr=="value")
			$retour.="url=url+'/'+$(this).val();\n";
		else
			$retour.="url=url+'/'+$(this).attr('".$attr."');\n";
		$retour.="$.post(url,$(".$form.").serialize()).done(function( data ) {\n";
		if($responseElement!=="")
			$retour.="\t$('".$responseElement."').html( data );\n";
		$retour.="\t".$function."\n
		});\n";
		if($validation){
			$retour="$('#".$form."').validate({submitHandler: function(form) {
			".$retour."
			}});\n";
			$retour.="$('#".$form."').submit();\n";
		}
		return $retour;
	}

	/**
	 * Effectue un POST d'un formulaire en ajax
	 * @param string $url Adresse de la requête
	 * @param string $form id du formulaire à poster
	 * @param string $responseElement id de l'élément HTML affichant la réponse
	 * @param string $function fonction appelée éventuellement après réception
	 */
	public static function postForm($url,$form,$responseElement,$validation=false,$function=NULL,$attr="id"){
		return JsUtils::addScript(JsUtils::_postForm($url, $form, $responseElement,$validation,$function,$attr));
	}


	public static function _setVal($element,$value,$function=""){
		return "$('".$element."').val(".$value.");\n".$function;
	}

	/**
	 * Affecte une valeur à un élément HTML
	 * @param string $element
	 * @param string $value
	 */
	public static function setVal($element,$value,$function=""){
		return JsUtils::addScript(JsUtils::_setVal($element, $value,$function));
	}

	public static function _setHtml($element,$html="",$function=""){
		return "$('".$element."').html('".$html."');\n".$function;
	}

	/**
	 * Affecte du html à un élément
	 * @param string $element
	 * @param string $html
	 */
	public static function setHtml($element,$html="",$function=""){
		return JsUtils::addScript(JsUtils::_setHtml($element, $html,$function));
	}

	public static function _setAttr($element,$attr,$value="",$function=""){
		return "$('".$element."').attr('".$attr."',".$value.");\n".$function;
	}

	/**
	 * Modifie l'attribut $attr d'un élément html
	 * @param string $element
	 * @param string $attr attribut à modifier
	 * @param string $value nouvelle valeur
	 */
	public static function setAttr($element,$attr,$value="",$function=""){
		return JsUtils::addScript(JsUtils::_setAttr($element, $attr, $value,$function));
	}

	/**
	 * Appelle la méthode JQuery $someThing sur $element avec passage éventuel du paramètre $param
	 * @param string $element
	 * @param string $someThing
	 * @param string $param
	 * @return mixed
	 */
	public static function _doSomethingOn($element,$someThing,$param="",$function=""){
		return "$('".$element."').".$someThing."(".$param.");\n".$function;
	}

	/**
	 * Appelle la méthode JQuery $someThing sur $element avec passage éventuel du paramètre $param
	 * @param string $element
	 * @param string $someThing
	 * @param string $param
	 * @return mixed
	 */
	public static function doSomethingOn($element,$someThing,$param="",$function=""){
		return JsUtils::addScript(JsUtils::_doSomethingOn($element, $someThing,$param,$function));
	}

	/**
	 * Effectue un get vers $url sur l'évènement $event de $element en passant les paramètres $params
	 * puis affiche le résultat dans $responseElement
	 * @param string $event
	 * @param string $element
	 * @param string $url
	 * @param string $params
	 * @param string $responseElement
	 * @param string $function
	 */
	 public static function getOn($event,$element,$url,$params="{}",$responseElement="",$function=NULL,$attr="id"){
		return JsUtils::bindToElement($element, $event,"function(event){". JsUtils::_get($url, $params,$responseElement,$function,$attr)."}");
	}

	/**
	 * Effectue un post vers $url sur l'évènement $event de $element en passant les paramètres $params
	 * puis affiche le résultat dans $responseElement
	 * @param string $event
	 * @param string $element
	 * @param string $url
	 * @param string $params
	 * @param string $responseElement
	 * @param string $function
	 */
	public static function postOn($event,$element,$url,$params="{}",$responseElement="",$function=NULL,$attr="id"){
		return JsUtils::bindToElement($element, $event,"function(event){". JsUtils::_post($url,$params,$responseElement,$function,$attr)."}");
	}

	/**
	 * Effectue un post vers $url sur l'évènement $event de $element en passant les paramètres du formulaire $form
	 * puis affiche le résultat dans $responseElement
	 * @param string $event
	 * @param string $element
	 * @param string $url
	 * @param string $form
	 * @param string $responseElement
	 * @param string $function
	 */
	public static function postFormOn($event,$element,$url,$form,$responseElement="",$validation=false,$function=NULL,$attr="id"){
		return JsUtils::bindToElement($element, $event,"function(event){". JsUtils::_postForm($url,$form,$responseElement,$validation,$function,$attr)."}");
	}

	/**
	 * Modifie la valeur de $elementToModify et lui affecte $valeur sur l'évènement $event de $element
	 * @param string $event
	 * @param string $element
	 * @param string $elementToModify
	 * @param string $value
	 * @return mixed
	 */
	public static function setOn($event,$element,$elementToModify,$value="",$function=""){
		return JsUtils::bindToElement($element, $event,"function(event){". JsUtils::_setVal($elementToModify, $value,$function)."}");
	}

	/**
	 * Modifie la valeur de $elementToModify et lui affecte $valeur sur l'évènement $event de $element
	 * @param string $event
	 * @param string $element
	 * @param string $elementToModify
	 * @param string $value
	 * @return mixed
	 */
	public static function setHtmlOn($event,$element,$elementToModify,$value="",$function=""){
		return JsUtils::bindToElement($element, $event,"function(event){". JsUtils::_setHtml($elementToModify, $value,$function)."}");
	}

	/**
	 *
	 * @param string $element
	 * @param string $event
	 * @param string $element
	 * @param string $someThing
	 * @param string $param
	 */
	public static function doSomeThingAndBindTo($element,$event,$elementToModify,$someThing,$param="",$function=""){
		return JsUtils::bindToElement($element, $event,"function(event){". JsUtils::_doSomethingOn($elementToModify, $someThing,$param,$function)."}");
	}

	public static function setChecked($elementPrefix,$values){
		$retour="";
		if(is_array($values)){
			foreach ($values as $value){
				$retour.="$('#".$elementPrefix.$value."').attr('checked', true);\n";
			}
		}else
			$retour="$('#".$elementPrefix."').attr('checked', ".StrUtils::getBooleanStr($values).");\n";
		return JsUtils::addScript($retour);
	}
}
