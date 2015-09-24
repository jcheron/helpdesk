<?php
use micro\orm\DAO;
use micro\js\Jquery;
use micro\utils\StrUtils;
use micro\views\Gui;
use micro\utils\RequestUtils;
class Sample extends \_DefaultController {
	public function ajaxSample(){
		echo $this->messageInfo("Cocher la case pour désactiver un utilisateur.<br>Cliquer sur une ligne pour modifier l'utilisateur associé.".
				"<div><label>Utilisateurs à désactiver : <input type='number' class='form-control' id='nb' value='0'></label></div>");
		echo $this->_showMessage("La condition de sortie n'est pas satisfaite !","danger",0,false,false);

		$users=DAO::getAll("User");
		echo '<form id="frmUsers"><ul class="list-group">';
		foreach ($users as $u){
			echo '<li class="list-group-item" id="'.$u->getId().'"><input type="checkbox" class="ck" name="user[]" id="user-'.$u->getId().'">&nbsp;'.$u->toString()."</li>";
		}
		echo "<li class='list-group-item list-group-item-info' id='divCount'><input type='hidden' id='res' value='0'>Aucun utilisateur désactivé</li>";
		echo "</ul></form>";
		echo "<button id='btClose' class='btn btn-primary'>Fermer</button>";
		Jquery::bindMethods(true,false);
		Jquery::getOn("click", ".list-group-item", "users/frm","#response");
		Jquery::doJqueryOn(".ck", "click", "$(event.target).parent()", "toggleClass",array("disabled","$(event.target).prop('checked')"));
		Jquery::postFormOn("click", ".ck", "sample/ajaxCount","frmUsers","#divCount");
		Jquery::doJqueryOn(".list-group-item", "mouseenter", "this", "addClass",array("active"));
		Jquery::doJqueryOn(".list-group-item", "mouseout", "this", "removeClass","active");
		Jquery::startCondition("$('#nb').val()==$('#res').val()","$('.alert-danger').show();");
		Jquery::doJqueryOn("#btClose", "click", "#response", "html","",Jquery::_doJquery("#main", "show"));
		Jquery::doJquery("#main", "hide");

		echo Jquery::compile();
	}

	public function ajaxCount(){
		$nb=sizeof(@$_POST["user"]);
		echo "<input type='hidden' id='res' value='".$nb."'>";
		echo Gui::pluriel("Utilisateur désactivé", "Utilisateurs désactivés", $nb);
	}
	public function liste(){
		$faqs=DAO::getAll("Faq");
		echo "<ul class='list-group'>";
		foreach ($faqs as $faq){
			echo "<li class='list-group-item' id='".$faq->getId()."'>".$faq."</li>";
		}
		echo "</ul>";
		echo Jquery::getOn("click", ".list-group-item", "sample/frmTitre","#responseFaq");
	}
	
	public function frmTitre($params){
		$faq=DAO::getOne("Faq", $params[0]);
		$this->loadView("faq/vUpdateTitre",array("faq"=>$faq));
		echo Jquery::postFormOn("click", "#btUpdateTitre", "sample/updateTitre", "frmTitre", "#responseFaq");
	}
	
	public function updateTitre(){
		if(RequestUtils::isPost()){
			$faq=DAO::getOne("Faq", $_POST["id"]);
			$faq->setTitre($_POST["titre"]);
			if(DAO::update($faq)){
				$this->messageInfo($faq." modifié","5000");
				Jquery::get("sample/liste","#liste");
				Jquery::doJquery(".alert", "hide","3000");
				echo Jquery::compile();
			}
		}
	}
}
