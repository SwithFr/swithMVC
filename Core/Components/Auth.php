<?php

namespace Core\Components;

use App\Config\AppConfig;
use Core\Models\Model;

class Auth
{

    /**
     * Permet de connecter un utilisateur
     * @param  stdClass $data Les données postées
     * @return bool              True si loggé, false sinon
     */
    public function login($data)
    {
        $model = new Model();
        $user = $model->getLogged(addslashes($data->login));
        $crypt = AppConfig::$cryptMethode;
        if ($user) {
            if ($crypt($data->password) != $user->password) {
                return false;
            } else {
                $this->id = $_SESSION['id'] = $user->id;
                $this->role = $_SESSION['role'] = $user->role;
                return true;
            }
        } else {
            return false;
        }

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
        return isset($_SESSION['id']) ? $_SESSION['id'] : false;
    }

    /**
     * Check si il y a un role dans la session
     * @return int|boolean Return le role ou false si pas de role
     */
    public function role()
    {
        return isset($_SESSION['role']) ? $_SESSION['role'] : false;
    }


    /**
     * Permet de déconnecter l'utilisateur
     */
    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['role']);
    }

}