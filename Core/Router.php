<?php

namespace Core;
use App\Config\App;
use App\Config\AppConfig;

class Router{

	/**
	 * Le prefixes à utiliser
	 * @var array
	 */
	static $prefixes = [];

	/**
	 * Permet de définir les préfixes
	 */
	public static function setPrefixes(){
		if(App::getInstance()->getAppSettings("prefixes"))
			Self::$prefixes = App::getInstance()->getAppSettings("prefixes");
	}

    /**
     * Permet de parser l'url (définir quel est le controller, quelle est l'action)
     * @param objet|Request $request objet Request
     * @internal param L $url 'url apellée par l'utilisateur
     */
	public static function parse(Request $request){
		// On enlève les / en début et fin d'url
		$url = trim($request->url,'/');

		// On créer un tableau à partir de l'URL
		$params = explode('/',$url);

		// On vérifie si on a un prefixe ou pas
		if(in_array($params[0], Self::$prefixes)){
			// Si oui on le stock dans la request 
			$request->prefixe = $params[0];

			// et on l'enlève du tableau URL
			array_shift($params);
		}

		// On déinit ensuite le controlleur
		$request->controller = $params[0];

		// On vérifie si y a pas une tentative de hack avec "l'ancien system" en vérifiant qu'on appelle pas controller/prefixe_action
		if(isset($params[1])){
			$action = $params[1];

			// On check si l'action n'est pas au format prefixe_action
			foreach (Self::$prefixes as $k) {
				if(strpos($action, $k.'_') === 0){
					// Si c'est le cas on définit le prefixe et on reformat l'action
					$request->prefixe = $k;
					$action = str_replace($k.'_', '', $action);
				}
			}
			$request->action = $action;
		}else{
			$request->action = App::getInstance()->getAppSettings("default_action");
		}
		$request->params = array_slice($params, 2);
	}

}