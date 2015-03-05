<?php

namespace Core;

use Core\Lib\SwithException;

/**
 * Se charge de charger le bon controller et la bonne action
 */
class Dispatcher
{

    // Objet Request qui contient toutes les variables utiles (controller, action, parmas, url...)
    public $request;

    public function __construct()
    {
        // On initialise l'objet Request
        $this->request = new Request();

        // On définit les prefixes s'il y en a
        Router::setPrefixes();

        // On parse l'url (définition du controller, action,...)
        Router::parse($this->request);

        // On affiche les erreurs ?
        if ($_ENV['DEBUG']) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            ini_set('display_errors', 0);
        }

        // On charge le bon controller
        try {
            $controller = $this->loadController();
        } catch (SwithException $e) {
            $controller = new Controllers\Controller("Controller");
            $controller->error($e->getMessage());
        }

        if (method_exists($controller, "beforeRender")) {
            $controller->beforeRender();
        }

        // On appelle la fonction
        if ($this->request->prefixe)
            $action = $this->request->prefixe . "_" . $this->request->action;
        else
            $action = $this->request->action;

        if (in_array($action, get_class_methods($controller))) {
            call_user_func_array([$controller, $action], $this->request->params);
        } else {
            $controller->error("Le controller " . $this->request->controller . " n'a pas de methode " . $action);
        }
        $controller->render($action);
    }

    /**
     * Permet d'initialiser le controller demandé par l'url
     * @throws SwithException
     * @return instance retourne une instance du controller.
     */
    private function loadController()
    {
        $controllerName = 'App\Controllers\\' . ucfirst($this->request->controller) . 'Controller';
        if (!class_exists($controllerName)) {
            $controllerName = 'Core\Controllers\\' . ucfirst($this->request->controller);
            if (!class_exists($controllerName)) {
                throw new SwithException("Controller introuvable", 404);
                return false;
            }
        }
        return new $controllerName($this->request, $this->request->controller);
    }

}