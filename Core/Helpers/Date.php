<?php


namespace Core\Helpers;


class Date 
{
    /**
     * Formate une date en français
     * @param $date
     * @param string $format
     * @return string
     */
    public static function dateToFr($date, $format = "Le %d %B %Y à %H:%M")
    {
        setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
        date_default_timezone_set('Europe/Paris');

        return strftime($format, strtotime($date));
    }
} 