<?php


namespace Core\Helpers;


class Paginator
{
    /**
     * Créer une petite pagination
     * @param int $nbPages
     * @return string
     */
    public static function paginate($nbPages)
    {
        $html = '<ul>';
        for ($i = 1; $i <= $nbPages; $i++) {
            $html .= "<li><a href='?page=$i'>$i</a></li>";
        }
        $html .= '</ul>';
        return $html;
    }
} 