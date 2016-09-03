<?php


namespace App\Controllers\Middlewares;


use Core\Controllers\Middlewares\Middleware;
use Core\Request;

class Test2Middleware implements Middleware
{

    public static function invoke(Request $request, callable $next)
    {
        var_dump('test2');
        $next();
    }
}