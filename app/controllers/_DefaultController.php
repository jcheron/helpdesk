<?php
class _DefaultController extends \BaseController {
	protected $className;
	protected $baseHref;
	protected $title;

	public function index(){
		global $config;
		$objects=DAO::getAll($this->className);
		echo "<table class='table table-striped'>";
		echo "<thead><tr><th>".$this->className."</th></tr></thead>";
		echo "<tbody>";
		foreach ($objects as $object){
			echo "<tr>";
			echo "<td>".$object->toString()."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a class='btn btn-primary' href='".$config["siteUrl"].get_class($this)."/frm'>Ajouter...</a>";
	}

	public function frm(){
		echo "Non implémenté...";
	}

	public function add(){
		echo "Non implémenté...";
	}

	/* (non-PHPdoc)
	 * @see BaseController::initialize()
	 */
	public function initialize() {
		$this->loadView("main/vHeader");
		echo "<div class='container'>";
		echo "<h1>".$this->title."</h1>";
	}

	/* (non-PHPdoc)
	 * @see BaseController::finalize()
	 */
	public function finalize() {
		echo "</div>";
		$this->loadView("main/vFooter");
	}

}