<?php


namespace Core\Components;


class Cache
{
    /**
     * Stocke le nom
     * @var
     */
    private static $cachename;

    private static $tmpDirectory = '../Tmp/';

    /**
     * Créer un fichier de cache
     * @param $filename
     * @param $content
     * @return int
     */
    private static function write($filename, $content)
    {
        return file_put_contents(self::$tmpDirectory . $filename, $content);
    }

    /**
     * Récupère le contenu d'un fichier cache
     * @param $filename
     * @return bool|string
     */
    private static function read($filename)
    {
        $file = self::$tmpDirectory . $filename;
        if (!file_exists($file)) {
            return false;
        }

        $lifetime = (time() - filemtime($file)) / 60; // Avoir le temps en minutes
        if ($lifetime > $_ENV['CACHE_DURATION']) {
            return false;
        }
        return file_get_contents($file);
    }

    /**
     * "Démarre" le cache
     * @param $cachename
     */
    public static function start($cachename)
    {
        if ($content = self::read($cachename)) {
            echo $content;
            self::$cachename = false;
            return true;
        }
        ob_start();
        self::$cachename = $cachename;
    }

    /**
     * "Arrête" le cache
     */
    public static function end()
    {
        if (!self::$cachename) {
            return false;
        }
        $content = ob_get_clean();
        echo $content;
        self::write(self::$cachename, $content);
    }
} 