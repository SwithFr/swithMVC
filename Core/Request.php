<?php

namespace Core;
use App\Config\AppConfig;

class Request{
	
	public  $url,             // url appellée par l'utilisateur
			$action,          // Action demandée
			$controller,      // Controller demandé
			$params,          // Les paramettres requis
			$prefixes = false,// Le prefixe requis si besoin
			$isPost = false,  // La methode est de type post ?
			$data = [],       // Les données postées
			$page =1;         // Pour la pagination       

	public function __construct(){

		if(isset($_SERVER['PATH_INFO'])){
			$this->url = $_SERVER['PATH_INFO'];
		}else{
			$this->url = isset(AppConfig::$defaultController) ? AppConfig::$defaultController : "Controller"."/".AppConfig::$defaultAction;
		}

		if(!empty($_POST)){
			$this->isPost = true;
			$this->data = $_POST;
		}

		if(isset($_GET['paginate']) && is_numeric($_GET['paginate']) && $_GET['paginate'] > 0)
			$this->page = round($_GET['paginate']);
	}
	

}