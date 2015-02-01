<?php

namespace Core\Components;

class Session{

	/*
		MÉTHODES
	 */

	public function __construct(){
		if(!isset($_SESSION))
			session_start();
	}

	/**
	 * Permet de définir un message flash
	 * @param string|array $message le message (ou le tableau de messages) à afficher
	 * @param string $type          le type de message [success]
	 */
	public function setFlash($message,$type = "success"){
		if(is_array($message)){
			$result = "";
			foreach ($message as $k => $v) {
				$result .= "<p>$v</p>";
			}
			$_SESSION['flash']['message'] = $result;
		}else{
			$_SESSION['flash']['message'] = $message;
		}
		$_SESSION['flash']['type'] = $type;
	}

	/**
	 * Permet d'afficher un message flash si il est défini
	 * @return string
	 */
	public function flash(){
		if(isset($_SESSION['flash'])){
			echo "<a href='#' class='alert alert-".$_SESSION['flash']['type']."'>".$_SESSION['flash']['message']."</a>";
			unset($_SESSION['flash']);
		}
	}

}