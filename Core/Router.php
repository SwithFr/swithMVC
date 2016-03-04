<?php

namespace Core;

use App\Config\App;
use SwithError\SwithError;

class Router
{

    /**
     * Le prefixes à utiliser
     * @var array
     */
    static $prefixes = [];

    /**
     * Les routes à utiliser
     * @var array
     */
    static $routes = [];

    /**
     * Permet de définir les préfixes
     */
    public static function setPrefixes()
    {
        if (App::getInstance()->getAppSettings("prefixes")) {
            Self::$prefixes = App::getInstance()->getAppSettings("prefixes");
        }
    }

    /**
     * Permet de parser l'url (définir quel est le controller, quelle est l'action)
     * @param Request $request objet Request
     */
    public static function parse(Request $request)
    {
        if(!$request->isRooted) {
            // On définit les prefixes s'il y en a
            Router::setPrefixes();

            // On enlève les / en début et fin d'url
            $url = trim($request->url, '/');

            // On créer un tableau à partir de l'URL
            $params = explode('/', $url);

            // On vérifie si on a un prefixe ou pas
            if (isset($params[0]) && in_array($params[0], self::$prefixes)) {
                // Si oui on le stock dans la request
                $request->prefixe = $params[0];

                // et on l'enlève du tableau URL
                array_shift($params);
            }

            // On déinit ensuite le controlleur
            $request->controller = !empty($params[0]) ? $params[0] : App::getInstance()->getAppSettings("default_controller");

            // On vérifie si y a pas une tentative de hack avec "l'ancien system" en vérifiant qu'on appelle pas controller/prefixe_action
            if (isset($params[1])) {
                $action = $params[1];

                // On check si l'action n'est pas au format prefixe_action
                foreach (Self::$prefixes as $k) {
                    if (strpos($action, $k . '_') === 0) {
                        // Si c'est le cas on définit le prefixe et on reformat l'action
                        $request->prefixe = $k;
                        $action = str_replace($k . '_', '', $action);
                    }
                }
                $request->action = $action;
            } else {
                $request->action = App::getInstance()->getAppSettings("default_action");
            }
            $request->params = array_slice($params, 2);
        }
    }

    /**
     * créer une connexion d'url
     * @param $url
     * @param array $params
     */
    public static function join($url, array $params = null)
    {
        self::$routes[] = new Route($url, $params);
    }

    /**
     * Check la requete et redirige si besoin
     * @param Request $request
     * @return Request
     */
    public static function run(Request $request)
    {
        // url de l'utilisateur
        $r_url = $request->url;

        // On parcoure les routes enregistrées via la fonction join
        foreach (self::$routes as $route) {
            // On initialise les erreurs à 0;
            $errors = 0;

            // On regarde si on a des paramettres définis par {param}
            // Si c'est le cas
            if ($route->hasParams()) {
                // On prend le bout de route qui nous interesse (donc sans les paramettres)
                $route->url = str_replace($route->paramsRouted, '', $route->url);

                // On récupère les paramettres de l'url de l'utilisateur
                $params_url = $route->getUserParams($r_url);

                // Et on leur enlève les /, { et }
                $route->cleanParams();
            }

            // On regarde si la route courrante ($route->url) est présente dans l'url de l'utilisateur
            $request->isRooted = !!preg_match('/(' . addcslashes($route->url, '/') . ')/', $r_url, $matches);

            // Si oui
            if (!empty($matches)) {
                // Si on a des parametres on créer un nouveau tableau sous la forme nom param => valeur
                if ($route->paramsRouted) {
                    $combinedParams = [];

                    if (count($route->paramsRouted) != count($params_url)) {
                        (new SwithError([
                            "title" => "Route invalide",
                            "message" => "La page demandé n'existe pas !"
                        ]))->display();
                    }
                    for ($i = 0; $i < count($route->paramsRouted); $i++) {
                        $combinedParams[$route->paramsRouted[$i]] = $params_url[$i];
                    }

                    // On vérifie qu'ils correspondent bien au format souhaité
                    foreach ($route->params['params'] as $pp => $r) {
                        foreach ($combinedParams as $k => $v) {
                            if (($k == $pp) && !preg_match($r, $v)) {
                                $errors++;
                            }
                        }
                    }
                }
                if ($errors == 0) {
                    $request->controller = $route->params['controller'];
                    $request->action = $route->params['action'];
                    $request->params = isset($params_url) ? $params_url : [];
                    $request->prefixe = isset($route->params['prefixe']) ? $route->params['prefixe'] : null;

                    return $request;
                }
            }
        }
        // Si on a pas d'erreur on modifie la requete
        if ($errors == 0) {
            return $request;
        } else {
            (new SwithError([
                "title" => "Route invalide",
                "message" => "La page demandé n'existe pas !"
            ]))->display();
        }
    }

}