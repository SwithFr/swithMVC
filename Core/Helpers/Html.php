<?php

namespace Core\Helpers;

class Html
{
    /**
     * Créer un lien
     * @param array | string $url
     * @param string $name
     * @param array $params
     * @param array $options
     * @return string
     */
    public static function link($url, $name, $params = [], $options = []){

        if(is_array($url)) {
            $controller = $url[0];
            $action = $url[1];
            $prefix = isset($url[2]) ? $url[2] : false;
            $url = $prefix ? $prefix . "/" . $controller . "/" . $action : $controller . "/" . $action;
        }

        if(isset($params['token'])){
            $query = "?token=" . $params['token'];
            unset($params['token']);
        } else {
            $query = "";
        }

        $return = "<a href='" . ROOT . $url;
        $param = $option = "";

        if ($params) {
            $count = count($params);
            foreach ($params as $k => $v) {
                $param .= "/$v";
            }
        }
        $return .= $param . $query . "' ";

        if ($options) {
            foreach ($options as $k => $v) {
                $option .= "$k='$v' ";
            }
            $return .= $option;
        }

        if (isset($count) && $count != 1) {
            $return .= "' >$name</a>";
        } else {
            $return .= " >$name</a>";
        }

        return $return;
    }

    /**
     * Génère une url
     * @param $route
     * @return string
     */
    public static function url($route)
    {
        return ROOT . $route;
    }

    /**
     * Génère une balise img
     * @param $src
     * @param null $alt
     * @param array $options
     * @return string
     */
    public static function img($src, $alt = null, Array $options = null)
    {
        $option = "";
        if ($options != null) {
            foreach ($options as $k => $v) {
                $option .= "$k='$v' ";
            }
        }
        $return = '<img src='. WEBROOT . DS . "img" . DS . $src .' alt="'.$alt.'"'.  $option .'>';
        return $return;
    }

    /**
     * Génère un lien css
     * @param $name
     * @return string
     */
    public static function css($name)
    {
        return "<link rel='stylesheet' type='text/css' href='" . WEBROOT . "css" . DS . "$name.css' media='screen' title='Normal' />";
    }

    /**
     * Génère un lien js
     * @param $name
     * @return string
     */
    public static function js($name)
    {
        return "<script type='text/javascript' src='" . WEBROOT . "js" . DS . "$name.js'></script>";
    }

    /**
     * Génère une balise i avec font awesome
     * @param $faIconName
     * @return string
     */
    public static function fa($faIconName)
    {
        return "<i class='fa fa-$faIconName'></i>";
    }

    /**
     * Génère une balise meta
     * @param $name
     * @param $value
     * @return string
     */
    public static function meta($name, $value)
    {
        return "<meta name='$name' content='$value' />";
    }

}