<?php
namespace micro\views\engine;

class Twig extends TemplateEngine{
	private $twig;
	public function __construct(){
		$loader = new \Twig_Loader_Filesystem(ROOT.DS."views/");
		$this->twig = new \Twig_Environment($loader, array(
				'cache' => ROOT.DS."views/cache/",
		));
	}
	/* (non-PHPdoc)
	 * @see TemplateEngine::render()
	 */
	public function render($viewName, $pData, $asString) {
		$pData["config"]=$GLOBALS["config"];
		$render=$this->twig->render($viewName,$pData);
		if($asString){
			return $render;
		}else
			echo $render;
	}
}
