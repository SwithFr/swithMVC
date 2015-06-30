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
            if (sha1(crypt($data->password,$_ENV['SALT_KEY'])) != $user->password) {
                return false;
            } else {
                $_SESSION['id'] = $user->id;
                $_SESSION['role'] = $user->role;
                if ($remember) {
                    Cookie::set("id", $user->id);
                    Cookie::set("role", $user->role);
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
        $data->password = sha1(crypt($data->password,$_ENV['SALT_KEY']));
        $userModel->create($data,'users');
    }

    /**
     * Permet de verifier si un utilisateur est connecté ou pas
     * @return bool
     */
    public function isLogged()
    {
        return isset($_SESSION['id']);
    }

    /**
     * Check si il y a un id dans la session
     * @return int|boolean Return l'id ou false si pas d'id
     */
    public function id()
    {
        return $_SESSION['id'];
    }

    /**
     * Check si il y a un role dans la session
     * @return int|boolean Return le role ou false si pas de role
     */
    public function role()
    {
        return $_SESSION['role'];
    }


    /**
     * Permet de déconnecter l'utilisateur
     */
    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['role']);
    }

    /**
     * Supprime les cookies
     */
    public function remove()
    {
        Cookie::remove("id");
        Cookie::remove("role");
    }

}