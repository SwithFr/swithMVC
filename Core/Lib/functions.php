<?php 

/**
 * "Foure tout"
 * FONCTIONS UTILES UN PEU PARTOUT 
 */

/**
 * Créer un petit débug
 * @param  var|array  $var la/les variable(s) à debugger
 * @param  boolean $die Doit-on couper le script ?
 */
function debug($var,$die = true){

    if ($_ENV['DEBUG'])
	echo "<pre>".var_dump($var)."</pre>";

	if($die)
		die();

}