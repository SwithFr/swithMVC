<?php

namespace Core\Components;

class Auth{
	
	/**
	 * L'id de l'utilisateur connecté
	 * @var string
	 */
	public $id = false;

	/**
	 * Le role de l'utilisateur connecté
	 * @var string
	 */
	public $role = false;

	public function __construct(){
		if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
			if(!$this->id){
				$this->id = $_SESSION['id'];
				unset($_SESSION['id']);
			}
		}
		if(isset($_SESSION['role']) && !empty($_SESSION['role'])){
			if(!$this->role){
				$this->role = $_SESSION['role'];
				unset($_SESSION['role']);
			}
		}
	}
	

}