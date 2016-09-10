<?php


namespace Core;


use App\Controllers\Middlewares\TestMiddleware;
use Core\Middlewares\Middleware;

class Route
{

    public $url;
    public $params;
    public $middlewares;
    public $paramsRouted;

    protected $currentMiddleware;

    function __construct($url, $params)
    {
        $this->url = $url;
        $this->params = $params;
        $this->getMiddleWares();
    }

    /**
     * Vérifie si une route a des paramettres ou non
     * @return bool
     */
    public function hasParams()
    {
        if (preg_match_all('/(\/?{[0-9a-zA-Z\-]+}\/?)/', $this->url, $params) > 0) {
            // On prend le premier resultat (truc chelou du preg_match qui retourne 2 resultats...)
            $this->paramsRouted = $params[0];
            return true;
        }

        return false;
    }

    /**
     * Supprime les parties inutiles des paramettres
     * c'est à dire les /, { et }
     */
    public function cleanParams()
    {
        foreach ($this->paramsRouted as $k => $v) {
            $this->paramsRouted[$k] = preg_replace('/(\/?\{)/', '', $v);
            $this->paramsRouted[$k] = preg_replace('/}\/?/', '', $this->paramsRouted[$k]);
        }
    }

    /**
     * Récupère les parametres de l'url utilisateur
     * @param $r_url
     * @return array
     */
    public function getUserParams($r_url)
    {
        $params_url = trim(str_replace($this->url, '', $r_url), '/');
        return explode('/', $params_url);
    }

    /**
     * Vérifie si la route utilise des middlewares
     * et les définis au besoin.
     */
    private function getMiddleWares()
    {
        if (isset($this->params['middlewares'])) {
        	$this->middlewares = $this->params['middlewares'];
            $this->currentMiddleware = 0;
            unset($this->params['middlewares']);
        }
    }

    /**
     * Vérifie si la route utilise des middlewares
     * @return bool
     */
    public function hasMiddlewares()
    {
        return !empty($this->middlewares);
    }


    /**
     * Invoque les middlewares de la route
     * @param $request
     */
    public function runMiddlewares($request)
    {
        /**
         * @var Middleware $middleware
         */
        $request->route = $this;
        if (isset($this->middlewares[$this->currentMiddleware])) {
            $middleware = '\\' . $this->middlewares[$this->currentMiddleware];
            $middleware::invoke($request, function() use ($request) {
                $this->currentMiddleware++;
                $this->runMiddlewares($request);
            });
        }
    }
}