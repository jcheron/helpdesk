<?php
namespace micro\js;
use micro\utils\StrUtils;
/**
 * Utilitaires d'insertion de scripts côté client (JQuery)
 * @author jc
 * @version 1.0.0.3
 * @package js
 */
class Jquery {
	private static $codes=array();
	private static $stopPropagation=false;
	private static $preventDefault=false;
	private static $condition=NULL;
	private static $else=NULL;
	private static $persists=false;

	private static function _prep_element($element){
		if (strrpos($element,'this')===false && strrpos($element,'event')===false){
			$element = '"'.$element.'"';
		}
		return $element;
	}

	private static function _prep_value($value){
		if(is_array($value)){
			$array=array_map("micro\js\Jquery::_prep_value",$value);
			$value=implode(",", $array);
		}else if (strrpos($value,'this')===false && strrpos($value,'event')===false && is_numeric($value)===false){
			$value = '"'.$value.'"';
		}
		return $value;
	}

	/**
	 * Ajoute $code à la liste des codes à exécuter
	 */
	private static function addToCodes($code){
		$codeObject=new JsCode($code);
		Jquery::$codes[]=$codeObject;
		return $codeObject;
	}

	private static function addScript($code){
		$code="$( document ).ready(function() {\n".$code."}\n);";
		return preg_filter("/(\<script[^>]*?\>)?(.*)(\<\/script\>)?/si", "<script>$2 </script>\n", $code,1);
	}

	public static function addParam($parameter,$params){
		$params=preg_filter("/[\{]?([^\\}]*)[\}]?/si", "$1", $params,1);
		$values=explode(",", $params);
		$values[]=$parameter;
		return "{".implode(",", $values)."}";
	}
	/**
	 * Associe du code javascript à exécuter sur l'évènement $event d'un élément DOM $element
	 */
	public static function bindToElement($element,$event,$jsCode){
		$function="function(event){";
		if(Jquery::$preventDefault){
			$function.="event.preventDefault();";
		}
		if(Jquery::$stopPropagation){
			$function.="event.stopPropagation();";
		}
		if(isset(Jquery::$condition)){
			$jsCode="if(".Jquery::$condition."){".$jsCode."}";
			if(isset(Jquery::$else)){
				$jsCode.=" else{".Jquery::$else."}";
			}
		}
		if(!Jquery::$persists){
			Jquery::$condition=NULL;
			Jquery::$else=NULL;
		}
		$function.=$jsCode."}";
		return Jquery::addToCodes("$(".Jquery::_prep_element($element).").bind('".$event."',".$function.");");
	}

	/**
	 * Exécute le script passé en paramètre, sur l'évènement $event généré sur $element
	 * @param String $script
	 * @param String $event
	 * @param String $element
	 * @return mixed
	 */
	public static function executeOn($element,$event,$script){
		return Jquery::bindToElement($element, $event, $script);
	}

	/**
	 * Exécute le script passé en paramètre
	 * @param String $script
	 * @return mixed
	 */
	public static function execute($script){
		return Jquery::addToCodes($script);
	}

	/**
	 * Effectue un GET en ajax
	 * @param string $url Adresse de la requête
	 * @param string $params Paramètres passés au format JSON
	 * @param string $responseElement id de l'élément HTML affichant la réponse
	 * @param string $function fonction appelée éventuellement après réception
	 */
	public static function _get($url,$responseElement="",$params="{}",$function=NULL,$attr="id"){
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
	public static function get($url,$responseElement="",$params="{}",$function=NULL,$attr="id"){
		return Jquery::addToCodes(Jquery::_get($url,$responseElement,$params,$function));
	}

	/**
	 * Effectue un POST en ajax
	 * @param string $url Adresse de la requête
	 * @param string $params Paramètres passés au format JSON
	 * @param string $responseElement id de l'élément HTML affichant la réponse
	 * @param string $function fonction appelée éventuellement après réception
	 */
	public static function _post($url,$responseElement="",$params="{}",$function=NULL,$attr="id"){
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
	public static function post($url,$responseElement="",$params="{}",$function=NULL,$attr="id"){
				return Jquery::addToCodes(Jquery::_post($url,$responseElement,$params,$function));

	}

	/**
	 * Effectue un POST d'un formulaire en ajax
	 * @param string $url Adresse de la requête
	 * @param string $form id du formulaire à poster
	 * @param string $responseElement id de l'élément HTML affichant la réponse
	 * @param string $function fonction appelée éventuellement après réception
	 */
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
		return Jquery::addToCodes(Jquery::_postForm($url, $form, $responseElement,$validation,$function,$attr));
	}

	/**
	 * Affecte une valeur à un élément HTML
	 * @param string $element
	 * @param string $value
	 */
	public static function _setVal($element,$value,$function=""){
		return "$(".Jquery::_prep_element($element).").val(".$value.");\n".$function;
	}

	/**
	 * Affecte une valeur à un élément HTML
	 * @param string $element
	 * @param string $value
	 */
	public static function setVal($element,$value,$function=""){
		return Jquery::addToCodes(Jquery::_setVal($element, $value,$function));
	}

	public static function _setHtml($element,$html="",$function=""){
		return "$(".Jquery::_prep_element($element).").html('".$html."');\n".$function;
	}

	/**
	 * Affecte du html à un élément
	 * @param string $element
	 * @param string $html
	 */
	public static function setHtml($element,$html="",$function=""){
		return Jquery::addToCodes(Jquery::_setHtml($element, $html,$function));
	}

	private static function _setAttr($element,$attr,$value="",$function=""){
		return "$('".$element."').attr('".$attr."',".$value.");\n".$function;
	}

	/**
	 * Modifie l'attribut $attr d'un élément html
	 * @param string $element
	 * @param string $attr attribut à modifier
	 * @param string $value nouvelle valeur
	 */
	public static function setAttr($element,$attr,$value="",$function=""){
		return Jquery::addToCodes(Jquery::_setAttr($element, $attr, $value,$function));
	}

	/**
	 * Appelle la méthode JQuery $someThing sur $element avec passage éventuel du paramètre $param
	 * @param string $element
	 * @param string $someThing
	 * @param string $param
	 * @return mixed
	 */
	public static function _doJquery($element,$someThing,$param="",$function=""){
		return "$(".Jquery::_prep_element($element).").".$someThing."(".Jquery::_prep_value($param).");\n".$function;
	}

	/**
	 * Appelle la méthode JQuery $someThing sur $element avec passage éventuel du paramètre $param
	 * @param string $element
	 * @param string $someThing
	 * @param string $param
	 * @return mixed
	 */
	public static function doJquery($element,$someThing,$param="",$function=""){
		return Jquery::addToCodes(Jquery::_doJquery($element, $someThing,$param,$function));
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
	 public static function getOn($event,$element,$url,$responseElement="",$params="{}",$function=NULL,$attr="id"){
		return Jquery::bindToElement($element, $event, Jquery::_get($url, $responseElement,$params,$function,$attr));
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
	public static function postOn($event,$element,$url,$responseElement="",$params="{}",$function=NULL,$attr="id"){
		return Jquery::bindToElement($element, $event,Jquery::_post($url,$responseElement,$params,$function,$attr));
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
		return Jquery::bindToElement($element, $event,Jquery::_postForm($url,$form,$responseElement,$validation,$function,$attr));
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
		return Jquery::bindToElement($element, $event,Jquery::_setVal($elementToModify, $value,$function));
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
		return Jquery::bindToElement($element, $event,Jquery::_setHtml($elementToModify, $value,$function));
	}

	/**
	 * Appelle la méthode JQuery $someThing sur $elementToModify avec passage éventuel du paramètre $param, sur l'évènement $event généré sur $element
	 * @param string $element
	 * @param string $event
	 * @param string $element
	 * @param string $someThing
	 * @param string $param
	 */
	public static function doJqueryOn($element,$event,$elementToModify,$someThing,$param="",$function=""){
		return Jquery::bindToElement($element, $event,Jquery::_doJquery($elementToModify, $someThing,$param,$function));
	}

	public static function setChecked($elementPrefix,$values){
		$retour="";
		if(is_array($values)){
			foreach ($values as $value){
				$retour.="$('#".$elementPrefix.$value."').attr('checked', true);\n";
			}
		}else
			$retour="$('#".$elementPrefix."').attr('checked', ".StrUtils::getBooleanStr($values).");\n";
		return Jquery::addToCodes($retour);
	}

	/**
	 * Retourne l'ensemble du code js à exécuter, entouré des balises script
	 * @return string le code à exécuter
	 */
	public static function compile(){
		$result="";
		foreach (Jquery::$codes as $c){
			$result.=$c->getCode();
		}
		return Jquery::addScript($result);
	}

	/**
	 * Efface les codes js à exécuter
	 */
	public static function clearCodes(){
		Jquery::$codes=array();
	}

	/**
	 * Définit les valeurs de stopPropagation et preventDefault dans l'association des évènements avec bindElement ou les fonctions se terminant par <b>On</b>
	 * @param boolean $stopPropagation
	 * @param boolean $preventDefault
	 */
	public static function bindMethods($stopPropagation=false,$preventDefault=false){
		Jquery::$preventDefault=$preventDefault;
		Jquery::$stopPropagation=$stopPropagation;
	}

	/**
	 * Pose une condition sur l'exécution du code associé à des évènements
	 * @param string $condition condition javascript à poser
	 * @param string $else code javascript à exécuter si la condition est fausse
	 * @param boolean $persists détermine si la condition est persistante.<br> Si vrai, elle sera appliquée également pour les évènements suivants
	 */
	public static function startCondition($condition,$else=NULL,$persists=true){
		Jquery::$condition=$condition;
		Jquery::$else=$else;
		Jquery::$persists=$persists;
	}

	/**
	 * Désactive une condition activée avec l'option $persists à true
	 */
	public static function endCondition(){
		Jquery::$condition=NULL;
		Jquery::$else=NULL;
		Jquery::$persists=false;
	}
}
