<?php

namespace Core;

use App\Config\App;

class Router
{

    /**
     * Le prefixes à utiliser
     * @var array
     */
    static $prefixes = [];

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
     * @param objet|Request $request objet Request
     * @internal param L $url 'url apellée par l'utilisateur
     */
    public static function parse(Request $request)
    {

        // On définit les prefixes s'il y en a
        Router::setPrefixes();

        // On enlève les / en début et fin d'url
        $url = trim($request->url, '/');

        // On créer un tableau à partir de l'URL
        $params = explode('/', $url);

        // On vérifie si on a un prefixe ou pas
        if (in_array($params[0], self::$prefixes)) {
            // Si oui on le stock dans la request
            $request->prefixe = $params[0];

            // et on l'enlève du tableau URL
            array_shift($params);
        }

        // On déinit ensuite le controlleur
        $request->controller = $params[0];

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

    /**
     * créer une connexion d'url
     * @param $url
     * @param array $params
     */
    public static function join($url, array $params = null)
    {
        self::$routes[] = ['url' => $url, 'params' => $params];
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
        foreach (self::$routes as $routedUrl) {
            // On regarde si on a des paramettres définis par {param}
            preg_match_all('/(\/?{[0-9a-zA-Z\-]+}\/?)/', $routedUrl['url'], $params);
            // Si c'est le cas
            if ($params) {
                // On prend le premier resultat (truc chelou du preg_match qui retourne 2 resultats...)
                $params = $params[0];

                // On prend le bout de route qui nous interesse (donc sans les paramettres)
                $routedUrl['url'] = str_replace($params, '', $routedUrl['url']);

                // On récupère les paramettres de l'url de l'utilisateur
                $params_url = trim(str_replace($routedUrl['url'], '', $r_url), '/');
                $params_url = explode('/', $params_url);
                // Et on leur enlève les /, { et }
                foreach ($params as $k => $v) {
                    $params[$k] = preg_replace('/(\/?\{)/', '', $v);
                    $params[$k] = preg_replace('/}\/?/', '', $params[$k]);
                }
            }

            // On regarde si la route courrante ($routedUrl['url']) est présente dans l'url de l'utilisateur
            preg_match('/(' . addcslashes($routedUrl['url'], '/') . ')/', $r_url, $matches);

            // Si oui
            if ($matches) {

                $errors = 0;

                // Si on a des parametres on créer un nouveau tableau sous la forme nom param => valeur
                if($params) {
                    $combinedParams = [];
                    for ($i = 0; $i < count($params); $i++) {
                        $combinedParams[$params[$i]] = $params_url[$i];
                    }
                    // On vérifie qu'ils correspondent bien au forma souhaité
                    foreach ($routedUrl['params']['params'] as $pp => $r) {
                        foreach ($combinedParams as $k => $v) {
                            if(($k == $pp) && !preg_match($r,$v)){
                                $errors++;
                            }
                        }
                    }
                }
            }
        }
        // Si on a pas d'erreur on modifie la requete
        if ($errors == 0) {
            $request->controller = $routedUrl['params']['controller'];
            $request->action = $routedUrl['params']['action'];
            $request->params = $params_url;
            return $request;
        } else {
            die('Url invalide');
        }
    }

}