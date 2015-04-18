<?php

namespace Core\Components;


class Auth
{
    private $id = false;
    private $role = false;

    /**
     * Permet de connecter un utilisateur
     * @param $user
     * @param  stdClass $data Les données postées
     * @return bool true si loggé, false sinon
     */
    public function login($user, $data)
    {
        $user = $user->getLogged(addslashes($data->login));
        if ($user) {
            if (sha1($data->password) != $user->password) {
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
        return $this->id;
    }

    /**
     * Check si il y a un role dans la session
     * @return int|boolean Return le role ou false si pas de role
     */
    public function role()
    {
        return $this->role;
    }


    /**
     * Permet de déconnecter l'utilisateur
     */
    public function logout()
    {
        $this->id = $this->role = false;
        unset($_SESSION['id']);
        unset($_SESSION['role']);
    }

}