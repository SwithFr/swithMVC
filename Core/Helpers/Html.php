<?php

namespace Core\Helpers;

class Html
{

    /**
     * Créer un lien
     * @param $lien
     * @param $name
     * @param array $params
     * @param array $options
     * @return string
     */
    public static function link($lien, $name, array $params = null, array $options = null)
    {
        $return = "<a href='" . ROOT . $lien;
        $param = $option = "";

        if ($params != null) {
            $count = count($params);
            foreach ($params as $k => $v) {
                $param .= "/$v";
            }
        }
        $return .= $param . "' ";

        if ($options != null) {
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
     * Créer un lien externe
     * @param $lien
     * @param $name
     * @param array $params
     * @param array $options
     * @return string
     */
    public static function url($lien, $name, array $params = null, array $options = null)
    {
        $return = "<a href='" . $lien;
        $param = $option = "";

        if ($params != null) {
            $count = count($params);
            foreach ($params as $k => $v) {
                $param .= "/$v";
            }
        }
        $return .= $param . "' ";

        if ($options != null) {
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
     * Génère une balise img
     * @param $src
     * @param null $alt
     * @param array $options
     * @return string
     */
    public static function img($src, $alt = null, array $options = null)
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

}