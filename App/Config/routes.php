<?php

use Core\Router;

Router::join('votre/url/{param1}/{param2}',[
    "controller" => 'controller',
    "action"     => 'action',
    "params"     => [
        "param1"    => '/[0-9]+/',
        "param2"  => '/[a-zA-Z\-]/'
    ]
]);