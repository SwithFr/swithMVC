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
        $this->db_settings = require(BASE . DS . 'App' . DS . 'Config' . DS . 'database.php');
        $this->app_settings = require(BASE . DS . 'App' . DS . 'Config' . DS . 'app_config.php');
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