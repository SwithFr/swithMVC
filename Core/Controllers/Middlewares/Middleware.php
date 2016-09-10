<?php


namespace Core\Controllers\Middlewares;


use Core\Request;

interface Middleware
{
    public static function invoke(Request $request, callable $next);
}