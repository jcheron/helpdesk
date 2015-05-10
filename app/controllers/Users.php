<?php
class Users extends \BaseController {

	public function index() {
		$users=DAO::getAll("User");
		echo "<table class='table table-striped'>";
		echo "<thead><tr><th>Mail</th><th>Login</th><th class='td-center'>Editer</th><th class='td-center'>Supprimer</th></tr></thead>";
		echo "<tbody>";
		foreach ($users as $user){
			echo "<tr>";
			echo 	"<td>".$user->getMail()."</td>".
					"<td>".$user->getLogin()."</td>".
					"<td class='td-center'><a class='btn btn-primary btn-xs' href='users/frm/".$user->getId()."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>".
					"<td class='td-center'><a class='btn btn-warning btn-xs' href='users/delete/".$user->getId()."'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a class='btn btn-primary' href='users/frm'>Ajouter un utilisateur...</a>";
	}

	public function frm($id=NULL){
		$user=new User();
		if(isset($id) && sizeof($id)>0){
			$user=DAO::getOne("User", $id[0]);
		}
		$this->loadView("user/vAdd",array("user"=>$user));
	}

	public function update(){
		global $config;
		if(RequestUtils::isPost()){
			$user=new User();
			RequestUtils::setValuesToObject($user,$_POST);
			$user->setAdmin(isset($_POST["admin"]));
			$href=$config["siteUrl"]."users";
			if($_POST["id"]){
				try{
					DAO::update($user);
					$msg="Utilisateur `{$user->toString()}` mis à jour";
					$this->loadView("main/vInfo",array("message"=>$msg,"href"=>$href,"type"=>"success"));
				}catch(Exception $e){
					$this->loadView("main/vInfo",array("message"=>"Impossible de modifier l'utilisateur","href"=>$href,"type"=>"danger"));
				}
			}else{
				try{
					DAO::insert($user);
					$msg="Utilisateur `{$user->toString()}` ajouté";
					$this->loadView("main/vInfo",array("message"=>$msg,"href"=>$href,"type"=>"success"));
				}catch(Exception $e){
					$this->loadView("main/vInfo",array("message"=>"Impossible d'insérer l'utilisateur","href"=>$href,"type"=>"danger"));
				}
			}
		}
	}
	public function delete($id){
		try{
			$href="users";
			$user=DAO::getOne("User", $id[0]);
			if($user!==NULL){
				DAO::delete($user);
				$msg="Utilisateur `{$user->toString()}` supprimé";
				$this->loadView("main/vInfo",array("message"=>$msg,"href"=>$href,"type"=>"success"));
			}else{
				$this->loadView("main/vInfo",array("message"=>"Utilisateur introuvable","href"=>$href,"type"=>"warning"));
			}
		}catch(Exception $e){
			$this->loadView("main/vInfo",array("message"=>"Impossible de supprimer l'utilisateur","href"=>$href,"type"=>"danger"));
		}
	}
	/* (non-PHPdoc)
	 * @see BaseController::initialize()
	 */
	public function initialize() {
		$this->loadView("main/vHeader");
		echo "<div class='container'>";
		echo "<h1>Utilisateurs</h1>";
	}

	/* (non-PHPdoc)
	 * @see BaseController::finalize()
	 */
	public function finalize() {
		echo "</div>";
		$this->loadView("main/vFooter");
	}
}