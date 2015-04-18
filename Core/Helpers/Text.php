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

} 