<?php


namespace App\Controllers\Middlewares;


use Core\Controllers\Middlewares\Middleware;
use Core\Request;

class TestMiddleware implements Middleware
{

    public static function invoke(Request $request, callable $next)
    {
        $next();
    }
}