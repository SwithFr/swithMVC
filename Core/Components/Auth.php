<?php

namespace Core\Components;
use Core\Models\Model;
use App\Config\AppConfig;

class Auth{

	/**
	 * Permet de connecter un utilisateur
	 * @param  Object User $user On passe le model User pour pouvoir faire les requete en bdd
	 * @param  stdClass    $data Les données postées
	 * @return bollean      
	 */
	public function login($user,$data){
		$user = $user->getLogged(addslashes($data->login));
		$crypt = AppConfig::$cryptMethode;
		if($user){
			if($crypt($data->password) != $user->password){
				return false;
			}else{
				$this->id = $_SESSION['id'] = $user->id;
				$this->role = $_SESSION['role'] = $user->role;
				return true;
			}
		}else{
			return false;
		}
		
	}

	public function isLogged(){
		return isset($_SESSION['id']);
	}

	/**
	 * Check si il y a un id dans la session
	 * @return int|boolean Return l'id ou false si pas d'id
	 */
	public function id(){
		return isset($_SESSION['id'])?$_SESSION['id']:false;
	}

	/**
	 * Check si il y a un role dans la session
	 * @return int|boolean Return le role ou false si pas de role
	 */
	public function role(){
		return isset($_SESSION['role'])?$_SESSION['role']:false;
	}

	public function logout(){
		unset($_SESSION['id']);		
		unset($_SESSION['role']);
	}

}