<?php

namespace App\Controllers;


class HomeController extends AppController
{

    # Pas besoin de model pour cette page de démonstration
    protected $hasModel = false;

    /**
     * Fonction d'accueil
     */
    public function index()
    {

    }

    public function avec()
    {
        var_dump("avec");die();
    }

    public function sans()
    {
        var_dump("sans");die();
    }

}