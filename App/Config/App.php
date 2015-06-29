<?php

namespace App\Config;


class App
{
    /**
     * Regroupe les configrations définies dans app_config.php
     * @var array|mixed
     */
    private $app_settings = [];

    /**
     * Singleton de l'instance App
     * @var
     */
    private static $_instance;


    /**
     * Retourne le singleton instancié
     * @return App
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        // Récupération des des paramettres
        $this->app_settings = require(BASE . DS . 'App' . DS . 'Config' . DS . 'app_config.php');

        // Chargement de l'envrionnement
        $env = $this->app_settings['environments_ip'][$_SERVER['SERVER_ADDR']];
        if (!file_exists('../Config/' . $env . '.env')) {
            die('Le fichier de configuration de l‘environnement <code>' . $env . '.env</code> est introuvable !');
        }

        (new \josegonzalez\Dotenv\Loader('../Config/' . $env . '.env'))->parse()->toEnv();
    }

    /**
     * Récupéré une configuration de l'App
     * @param $key
     * @return null
     */
    public function getAppSettings($key)
    {
        if (!isset($this->app_settings[$key])) {
            return null;
        }
        return $this->app_settings[$key];
    }

} 