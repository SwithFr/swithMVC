<?php


namespace Core\Helpers;


class CSRFTool
{

    /**
     * Génere un token de sécurité pour les failles csrf
     * @return string
     */
    public static function generateToken()
    {
        return $_SESSION['token'] = md5(isset($_SESSION['id']) ? $_SESSION['id'] . time() : rand(1,10000) . time());
    }

    /**
     * Vérifie si le token de l'url correspond bien à celui de l'utilisateur connecté
     * @return bool
     */
    public static function check()
    {
        return self::getPassedToken() === self::getAuthToken();
    }

    /**
     * Récupere le token de l'utilisateur
     * @return null
     */
    public static function getAuthToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }

    /**
     * Récupère le token passé dans l'url
     * @return bool
     */
    public static function getPassedToken()
    {
        return isset($_GET['token']) ? $_GET['token'] : isset($_POST['token']) ? $_POST['token'] : false;
    }

    /**
     * Supprime le token de la session
     */
    public static function removeToken()
    {
        unset($_SESSION['token']);
    }
}