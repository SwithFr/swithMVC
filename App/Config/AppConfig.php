<?php 

namespace App\Config;

class AppConfig{

	/**
	 * Le nom de votre site
	 * @var string
	 */
	static $appName = "Mon MVC";

	/**
	 * Controller à charger par defaut
	 * @var string
	 */
	static $defaultController = "pages";

	/**
	 * Action à appeller par défaut
	 * @var string
	 */
	static $defaultAction = "index";

	/**
	 * Tableau contenant les différentes configuarations des bases de données
	 * @var [type]
	 */
	static $databases = [
		"default" => [
			"host"     => "localhost",
			"login"    => "root",
			"password" => "root",
			"dbname"   => "swithmvc",
			"encode"   => "UTF8"
		]
	];

	/**
	 * Afficher les message d'erreurs ou pas 
	 * @var boolean
	 */
	static $debug = true;

	/**
	 * Permet de définir des prefixes
	 * @var array [admin,user]
	 */
	static $prefixes = ['admin','user'];

}
