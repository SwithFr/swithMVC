<?php

namespace App\Config;


class App
{

    private $db_settings = [];
    private $app_settings = [];
    private static $_instance;


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
        $this->db_settings = require(BASE . DS . 'App' . DS . 'Config' . DS . 'database.php');
        $this->app_settings = require(BASE . DS . 'App' . DS . 'Config' . DS . 'app_config.php');

        // Chargement de l'envrionnement
        $env = $this->app_settings['environments_ip'][$_SERVER['REMOTE_ADDR']];
        if (!file_exists('../Config/' . $env . '.env'))
            die('Le fichier de configuration de l‘environnement <code>' . $env . '.env</code> est introuvable !');

        (new \josegonzalez\Dotenv\Loader('../Config/' . $env . '.env'))->parse()->toEnv();
    }

    public function getDbSettings($key)
    {
        if (!isset($this->db_settings[$key])) {
            return null;
        }
        return $this->db_settings[$key];
    }

    public function getAppSettings($key)
    {
        if (!isset($this->app_settings[$key])) {
            return null;
        }
        return $this->app_settings[$key];
    }


} 