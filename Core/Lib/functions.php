<?php

/**
 * "Foure tout"
 * FONCTIONS UTILES UN PEU PARTOUT
 */

/**
 * Créer un petit débug
 * @param  var|array $var la/les variable(s) à debugger
 * @param  boolean $die Doit-on couper le script ?
 */
function debug($var, $die = true)
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