<?php

namespace Core\Controllers;

use Core\Components\Session;
use Core\Request;

/**
 * Controller principal (dont tous les autres héritent)
 * Contient les fonctions communes à tous les controllers.
 */
class Controller
{

    /**
     * Le nom du controller (pour connaitre le model plus facilement)
     * @var string
     */
    public $name;

    /**
     * La requete tapée par l'utilisateur
     * @var Object Request
     */
    public $request;

    /**
     * La Session
     * @var Object Session
     */
    public $Session = false;

    /**
     * Le layout à charger [defaut]
     * @var string
     */
    public $layout = 'default';

    /**
     * Si jamais on a pas besoins de vue
     * @var boolean [true]
     */
    public $needRender = true;

    /**
     * Les variables à envoyer à la vue
     * @var Array
     */
    private $vars = [];

    /**
     * Pour savoir si une vue à déjà été rendu ou non
     * @var boolean
     */
    private $rendered = false;

    /**
     * Le model Lié au controller
     * @var Object Model
     */
    public $model;

    /**
     * Tableau des composants à charger
     * @var array
     */
    protected $components = [];

    /**
     * Tableau des composants déjà chargés
     * @var array
     */
    private $loadedComponents = [];

    /**
     * Nom de la vue
     * @var null
     */
    public $view = null;


    public function __construct(Request $request = null, $name)
    {
        $this->request = $request;
        $this->request->prefixe ? $this->request->prefixe . '_' . $this->request->action : $this->request->action;
        $this->name = $name;
        $this->loadModel();
        if (!$this->Session)
            $this->Session = new Session();

        foreach ($this->components as $c) {
            if (!array_key_exists($c, $this->loadedComponents)) {
                $className = 'Core\\Components\\' . $c;
                $this->$c = new $className();
                $this->loadedComponents[] = $c;
            }
        }
    }

    /**
     * Permet de charger la vue qui correspond à l'action
     * @param  string $view le nom de la vue à charger
     */
    public function render($view)
    {
        if ($this->rendered || !$this->needRender) {
            return false;
        }
        extract($this->vars);
        $view = BASE . DS . 'App' . DS . 'Views' . DS . ucfirst($this->request->controller) . DS . $view . '.php';
        if (!file_exists($view)) {
            $view = BASE . DS . 'Core' . DS . 'Views' . DS . ucfirst($this->request->controller) . DS . $this->request->action . '.php';
            if (!file_exists($view)) {
                $this->error("viewNotFound",$this->request->controller,$this->view);
            }
        }
        ob_start();
        require($view);
        $content_for_layout = ob_get_clean();
        $layout = BASE . DS . 'App' . DS . 'Views' . DS . 'Layouts' . DS . $this->layout . '.php';
        if (!file_exists($layout)) {
            $layout = BASE . DS . 'Core' . DS . 'Views' . DS . 'Layouts' . DS . $this->layout . '.php';
            if (!file_exists($layout)) {
                $this->error("layoutNotFound", $this->layout);
            }
        }
        require($layout);
        $this->rendered = true;
    }

    /**
     * Permet de définir les variables à envoyer à la vue
     * @param $key   le nom de la variable
     * @param $value sa valeur
     * @return array le tableau des variables
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $this->vars += $key;
        } else {
            $this->vars[$key] = $value;
        }

    }

    /**
     * Permet de renvoyer vers une page d'erreur
     * @param $type
     */
    public function error($type,$ctrlName = null, $methodeName = null, $layout = null)
    {
        if($type == 'controllerNotFound') {
            $this->redirect('errors/' . $type . '/' . $ctrlName);
        } elseif($type == 'methodeNotFound' || $type == 'viewNotFound') {
            $this->redirect('errors/' . $type . '/' . $ctrlName . '/' . $methodeName);
        }elseif($type == 'layoutNotFound') {
            $this->redirect('errors/' . $type . '/' . $layout);
        }
    }

    /**
     * Permet de charger une instance du model lié au controlleur dans $this->nomDuModel
     * @param  string $name le nom du model que l'on veut charger [null]
     */
    public function loadModel($name = null)
    {
        if (is_null($name)) {
            $name = ucfirst(substr($this->name, 0, -1));
        }
        $modelName = "App\\Models\\" . $name;
        if (!class_exists($modelName)) {
            $modelName = "Core\\Models\\" . $name;
            if (!class_exists($modelName))
                return false;
        }
        if (!isset($this->$name)) {
            $this->$name = new $modelName($this->request->data);
        }
    }

    /**
     * Regirige vers le chemin spécifié
     * @param $path chemin
     */
    public function redirect($path = null)
    {
        header("Location:" . ROOT . $path);
        exit();
    }

    /**
     * Permet d'afficher un élément (~= widget)
     * @param $name le nom de l'élément que l'on souhaite afficher
     */
    function element($name)
    {
        include_once BASE . DS . "App" . DS . "Views" . DS . "Elements" . DS . $name . ".php";
    }

}