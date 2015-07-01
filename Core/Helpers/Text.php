<?php

namespace Core\Helpers;


class Text
{

    /**
     * Permet de tronquer un texte
     * @param $text
     * @param $limit
     * @return string
     */
    public static function cut($text, $limit)
    {
        if (strlen($text) > $limit) {
            $text = wordwrap($text, $limit, '\br');
            $text = explode('\br', $text);
            $text = $text[0] . '&nbsp;&hellip;';
        }

        return $text;
    }

    /**
     * Transofrme une chaine de caractère en slug
     * @param $string
     * @return string
     */
    public static function toSlug($string)
    {
        return strtolower(str_replace(' ', '-',self::removeAccent($string)));
    }

    /**
     * Supprime les accents d'une chaine de caractères
     * @param $string
     * @return string
     */
    public static function removeAccent($string)
    {
        return str_replace(
            array(
                'à', 'â', 'ä', 'á', 'ã', 'å',
                'î', 'ï', 'ì', 'í',
                'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
                'ù', 'û', 'ü', 'ú',
                'é', 'è', 'ê', 'ë',
                'ç', 'ÿ', 'ñ',
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a',
                'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u',
                'e', 'e', 'e', 'e',
                'c', 'y', 'n',
            ),
            $string
        );
    }

} 