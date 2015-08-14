<?php

namespace Core\Components;


use Core\Lib\Cookie;

class Auth
{
    /**
     * Permet de connecter un utilisateur
     * @param $userModel
     * @param  stdClass $data Les données postées
     * @param $remember
     * @return bool true si loggé, false sinon
     */
    public function login($userModel, $data, $remember = false)
    {
        $user = $userModel->getLogged(addslashes($data->login));
        if ($user) {
            // on évite les collisions avec une surcouche de cryptage
            if ($this->encryptData($data->password) != $user->password) {
                return false;
            } else {
                $_SESSION['id'] = $user->id;
                if (isset($user->role)) {
                    $_SESSION['role'] = $user->role;
                }
                if ($remember) {
                    Cookie::set("id", $user->id);
                    if (isset($user->role)) {
                        Cookie::set("role", $user->role);
                    }
                }
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Créer un nouvel utilisateur
     * @param $userModel
     * @param $data
     */
    public function register($userModel, $data){
        $data->login = addslashes($data->login);
        $data->password = $this->encryptData($data->password);
        $userModel->create($data,'users');
    }

    /**
     * Permet de verifier si un utilisateur est connecté ou pas
     * @return bool
     */
    public function isLogged()
    {
        return isset($_SESSION['id'])||isset($_COOKIE['id']);
    }

    /**
     * Check si il y a un id dans la session
     * @return int|boolean Return l'id ou false si pas d'id
     */
    public function id()
    {
        return isset($_SESSION['id']) ? $_SESSION['id'] : false ;
    }

    /**
     * Check si il y a un role dans la session
     * @return int|boolean Return le role ou false si pas de role
     */
    public function role()
    {
        return isset($_SESSION['role']) ? $_SESSION['role'] : false ;
    }


    /**
     * Permet de déconnecter l'utilisateur
     * @param bool $remove
     */
    public function logout($remove = false)
    {
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        if ($remove) {
            $this->remove();
        }
    }

    /**
     * Supprime les cookies
     */
    public function remove()
    {
        Cookie::remove("id");
        Cookie::remove("role");
    }

    /**
     * crypte une chaine de caractères
     * @param $data
     * @return string
     */
    public function encryptData($data)
    {
        return sha1(crypt($data,$_ENV['SALT_KEY']));
    }

}