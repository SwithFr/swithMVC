<?php


namespace Core\Helpers;


class Paginator
{
    /**
     * Créer une petite pagination
     * @param $paginateResults
     * @return string
     */
    public static function paginate($paginateResults)
    {
        $html = '<ul class="pagination">';
        for ($i = 1; $i <= $paginateResults['nbPages']; $i++) {
            $html .= "<li><a href='?paginate=$i'>$i</a></li>";
        }
        $html .= '</ul>';
        return $html;
    }
} 