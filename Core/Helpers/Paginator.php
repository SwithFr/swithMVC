<?php


namespace Core\Helpers;


class Paginator
{
    /**
     * Créer une petite pagination
     * Si $previousAndNext est à true, on a en plus les liens suivant et précédant
     * @param int $nbPages
     * @param bool $previousAndNext
     * @param bool $active
     * @return string
     */
    public static function paginate($nbPages, $previousAndNext = false, $active = true)
    {
        $html = self::start($previousAndNext);

        for ($i = 1; $i <= $nbPages; $i++) {
            if ($active) {
                $activeClass = $_GET['page'] == $i ? 'class="active"' : '';
            } else {
                $activeClass = "";
            }
            $html .= "<li $activeClass ><a href='?page=$i'>$i</a></li>";
        }

        $html .= self::end($previousAndNext, $nbPages);

        return $html;
    }

    /**
     * Démarre la liste de pagination
     * @param $previous
     * @return string
     */
    public static function start($previous)
    {
        $html = "<ul>";
        if ($previous) {
            $page = $_GET['page'] - 1 <= 1 ? 1 : $_GET['page'] - 1;
            if ($_GET['page'] != 1) {
                $html .= "<li><a href='?page={$page}'><</a></li>";
            }
        }
        return $html;
    }

    /**
     * Termine la liste de pagination
     * @param $next
     * @param $nbPages
     * @return string
     */
    public static function end($next, $nbPages)
    {
        $html = "";
        if ($next) {
            $page = $_GET['page'] + 1 >= $nbPages ? $nbPages : $_GET['page'] + 1;
            if ($_GET['page'] != $nbPages) {
                $html .= "<li><a href='?page={$page}'>></a></li>";
            }
        }
        $html .= "</ul>";

        return $html;
    }
} 