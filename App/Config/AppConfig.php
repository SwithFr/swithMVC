<?php 

namespace App\Config;

class AppConfig{

	/**
	 * Le nom de votre site
	 * @var string
	 */
	public static $appName = "Nom du site";

	/**
	 * Controller à charger par defaut
	 * @var string
	 */
	#static $defaultController = "pages";

	/**
	 * Action à appeller par défaut
	 * @var string
	 */
	public static $defaultAction = "index";

	/**
	 * Tableau contenant les différentes configuarations des bases de données
	 * @var [type]
	 */
	public static $databases = [
		"default" => [
			"host"     => "localhost",
			"login"    => "root",
			"password" => "root",
			"dbname"   => "dbName",
			"encode"   => "UTF8"
		]
	];

	/**
	 * Afficher les message d'erreurs ou pas 
	 * @var boolean
	 */
	public static $debug = true;

	/**
	 * Permet de définir des prefixes
	 * @var array [admin,user]
	 */
	public static $prefixes = ['admin','user'];

	/**
	 * La méthode de cryptage
	 * @var string Le nom de la fonction de cryptage
	 */	
	public static $cryptMethode = "sha1";

}
