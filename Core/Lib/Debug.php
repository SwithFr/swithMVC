<?php


namespace Core\Lib;


class Debug 
{
    /**
     * Créer un petit débug
     * @param  var|array $var la/les variable(s) à debugger
     * @param  boolean $die Doit-on couper le script ?
     */
    public static function debug($var, $die = true)
    {
        if ($_ENV['DEBUG']) {
            $debug = debug_backtrace();
            echo "<p><strong>" . $debug[0]['file'] . " ligne : " . $debug[0]['line'] . "</strong></p>";
            echo "<pre>";
            var_dump($var);
            echo "</pre>";
        }

        if ($die) {
            die();
        }
    }

    /**
     * Paramettre l'affichage des erreurs en fonction de l'environnement
     */
    public static function set()
    {
        if ($_ENV['DEBUG']) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            ini_set('display_errors', 0);
        }
    }
} 