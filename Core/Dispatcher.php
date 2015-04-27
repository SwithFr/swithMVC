<?php

namespace Core;

use Core\Lib\SwithException;

/**
 * Se charge de charger le bon controller et la bonne action
 */
class Dispatcher
{

    /**
     * Objet Request qui contient toutes les variables utiles (controller, action, parmas, url...)
     * @var Request
     */
    public $request;

    /**
     * Vérifie que les information de base on bien été configurées
     * @var bool
     */
    private $isVerified = false;

    /**
     *
     */
    public function __construct()
    {
        // On initialise l'objet Request
        $this->request = new Request();

        // On parse l'url (définition du controller, action,...)
        Router::parse($this->request);

        if($_ENV['USE_ROUTES']) {
            require('../Config/routes.php');
            $this->request = Router::run($this->request);
        }

        // On affiche les erreurs ?
        if ($_ENV['DEBUG']) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            ini_set('display_errors', 0);
        }

        if (!$this->isVerified) {
            $this->verify();
        }

        // On charge le bon controller
        try {
            $controller = $this->loadController();
        } catch (SwithException $e) {
            $controller = new Controllers\Errors($this->request, "ErrorsController");
            $controller->error('controllerNotFound', $this->request->controller);
        }

        if (method_exists($controller, "beforeRender")) {
            $controller->beforeRender();
        }

        // On appelle la fonction
        if ($this->request->prefixe)
            $action = $this->request->prefixe . "_" . $this->request->action;
        else
            $action = $this->request->action;

        $availablesActions = array_diff(get_class_methods($controller),get_class_methods(get_parent_class($controller)));
        if (in_array($action, $availablesActions)) {
            call_user_func_array([$controller, $action], $this->request->params);
        } else {
            $controller->error('methodeNotFound', $this->request->controller, $action);
        }

        $controller->render($controller->view);
    }

    /**
     * Permet d'initialiser le controller demandé par l'url
     * @throws SwithException
     * @return instance retourne une instance du controller.
     */
    private function loadController()
    {
        $controllerName = 'App\\Controllers\\' . ucfirst($this->request->controller) . 'Controller';
        if (!class_exists($controllerName)) {
            $controllerName = 'Core\\Controllers\\' . ucfirst($this->request->controller);
            if (!class_exists($controllerName)) {
                throw new SwithException("Controller introuvable", 404);
                return false;
            }
        }
        return new $controllerName($this->request, $this->request->controller);
    }

    private function verify()
    {
        echo "<div class='container'>";
        if ($_ENV['SALT_KEY'] == '2129762b19c044ab7f49ea8995f7795e886ea4be')
            echo "<div class='alert alert-warning'>Pensez à bien modifier la clé de sécurité dans le fichier <code>App/Config/*.env</code> correspondant à votre environnment actuel</div>";
        if ($_ENV['DB_HOST'] == 'host_name' || $_ENV['DB_LOGIN'] == 'database_login')
            echo "<div class='alert alert-warning'>Configurez votre fichier <code>App/Config/app_config.php</code> avant tout !</div>";
        echo "</div>";

        $this->isVerified = true;
    }

}