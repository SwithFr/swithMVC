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
            if(is_array($var)) {
                foreach($var as $v) {
                    self::display($v);
                }
            } else {
                self::display($var);
            }
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

    /**
     * Affiche le debug une variable
     * @param mixed $var
     */
    private static function display($var)
    {
        $debug = debug_backtrace();
        echo "<div style='background-color: #dbcfbe;'>";
        echo "<p style='background-color: #2b303b; color: #ffffff; padding: .5em; margin: 1em 0 0;'><strong>" . $debug[0]['file'] . " <span style='color:red;'>ligne : " . $debug[0]['line'] . "</span></strong></p>";
        echo "<pre style='padding: .5em; margin: 0;'>";
        var_dump($var);
        echo "</pre>";
        echo "</div>";
    }
} 