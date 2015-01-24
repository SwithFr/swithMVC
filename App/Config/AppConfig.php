<?php 

namespace App\Config;

/**
 * Class AppConfig
 * Class de configuration de l'application
 * Contient l'ensemble des variables utiles
 * @documentation https://swith-mvc.shost.ca/pages/documentation/commencer
 * @package App\Config
 */
class AppConfig{

	/**
	 * Le nom de votre application
	 * @var string
	 */
	static $appName = "Mon site";

	/**
	 * Controller à charger par défaut
     * Il n'est pas obligatoire de le préciser
     * Par défaut, ce sera le controller Core\Controllers\Controller
     * qui sera chargé.
     * Cependant si vous voulez définir une page d'accueil par défaut vous pouvez le faire ici.
	 * @var string
	 */
	// static $defaultController = "pages";

	/**
	 * Action à appeler par défaut
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
			"dbname"   => "NomBdd",
			"encode"   => "UTF8"
		]
	];

	/**
	 * Afficher les message d'erreurs ou pas
     * A définir à false en production
	 * @var boolean
	 */
	static $debug = true;

	/**
	 * Permet de définir des prefixes
	 * @var array [admin,user]
	 */
	static $prefixes = ['admin','user'];

	/**
	 * La méthode de cryptage
	 * @var string Le nom de la fonction de cryptage
	 */	
	static $cryptMethode = "sha1";

}
