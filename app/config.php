<?php
return array(
		"siteUrl"=>"http://127.0.0.1/helpdesk/",
		"documentRoot"=>"DefaultC",
		"database"=>[
				"dbName"=>"helpdesk",
				"serverName"=>"127.0.0.1",
				"port"=>"3306",
				"user"=>"root",
				"password"=>""
		],
		"onStartup"=>function($action){
			if(!Auth::isAuth() && $action[0]!=="UserAuth" && @$action[1]!=="disconnect"){
				if(array_key_exists("autoConnect", $_COOKIE)){
					$_SESSION["action"]=$action;
					$ctrl=new UserAuth();
					$ctrl->initialize();
					$ctrl->signin_with_hybridauth(array($_COOKIE["autoConnect"]));
					$ctrl->finalize();
					die();
				}
			}
		},
		"directories"=>["my","tests"],
		"templateEngine"=>'micro\views\engine\Twig',
		"test"=>true
);