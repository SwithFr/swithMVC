<?php


namespace Core;


class Route
{

    public $url;
    public $params;
    public $paramsRouted;

    function __construct($url, $params)
    {
        $this->url = $url;
        $this->params = $params;
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
}