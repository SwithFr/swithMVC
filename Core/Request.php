<?php

namespace Core;

use App\Config\App;
use Core\Helpers\CSRFTool;

class Request
{

    public $url,             // url appellée par l'utilisateur
           $action,          // Action demandée
           $controller,      // Controller demandé
           $referer = null,  // Page précédante
           $params,          // Les paramettres requis
           $prefixe = false, // Le prefixe requis si besoin
           $isPost = false,  // La methode est de type post ?
           $isRooted = false,// Si la requete est passé par une route personnalisée
           $data = false,    // Les données postées
           $page = 1;        // Pour la pagination

    public function __construct(App $app)
    {
        $default_controller = ucfirst($app->getAppSettings("default_controller"));

        if (isset($_SERVER['PATH_INFO'])) {
            $this->url = $_SERVER['PATH_INFO'];
        } else {
            $this->url = (!is_null($default_controller) ? $default_controller : "Controller") . "/" . $app->getAppSettings("default_action");
        }

        $this->setReferrer();

        $this->setData();

        $this->setPageParametter();
    }

    /**
     * Permet de définir un referer si possible
     */
    private function setReferrer()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $root = (ROOT === '/') ? $_SERVER['HTTP_HOST'] : ROOT;
            $root = addcslashes($root, DS);
            $parts = preg_split('/' . $root . '/', $_SERVER['HTTP_REFERER'], 2);
            $this->referer = trim(end($parts), DS);
        }
    }

    /**
     * Défini les donnée postée
     */
    private function setData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $this->isPost = true;
            $this->data = new \stdClass();
            foreach ($_POST as $k => $v) {
                $this->data->$k = $v;
            }
            unset($_POST);

            $_POST['token'] = CSRFTool::getAuthToken();
        }
    }

    /**
     * Défini le nurméo de page si besoin.
     */
    private function setPageParametter()
    {
        if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
            $this->page = round($_GET['page']);
        }
    }

    /**
     * Récupère l'action de la requete
     * @return string
     */
    public function getAction()
    {
        if ($this->prefixe) {
            return $this->prefixe . "_" . $this->action;
        } else {
            return $this->action;
        }
    }
}