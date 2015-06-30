<?php


namespace Core\Lib;


class Cookie
{
    /**
     * Récupère la valeur d'un cookie
     * @param $key
     * @return bool
     */
    public static function get($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
    }

    /**
     * Créer un cookie
     * @param $key
     * @param $value
     * @param null $time
     * @return bool
     */
    public static function set($key, $value, $time = null)
    {
        if (is_null($time)) {
            $time = time() + $_ENV['COOKIE_DURATION'];
        }

        setcookie($key, $value, $time);

        return true;
    }

    /**
     * Supprime un cookie
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        setcookie($key, "", time() - $_ENV['COOKIE_DURATION']);
        return true;
    }
} 