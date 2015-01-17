<?php

namespace Core;
use App\Config\AppConfig;

class Router{

	/**
	 * Les prefixes à utiliser
	 * @var array
	 */
	static $prefixes = [];

	/**
	 * Permet de définir les préfixes
	 */
	public static function setPrefixes(){
		if(isset(AppConfig::$prefixes))
			Self::$prefixes = AppConfig::$prefixes;
	}
	
	/**
	 * Permet de parser l'url (définir quel est le controller, quelle est l'action)
	 * @param  $url L'url apellée par l'utilisateur
	 * @param  $request objet Request
	 */
	public static function parse(Request $request){
		$url = trim($request->url,'/');
		$params = explode('/',$url);
		if(in_array($params[0], Self::$prefixes)){
			$request->prefixes = $params[0];
			array_shift($params);
		}
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : AppConfig::$defaultAction;
		$request->params = array_slice($params, 2);
	}

}