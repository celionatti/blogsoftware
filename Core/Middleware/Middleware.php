<?php

namespace Core\Middleware;

use Exception;
use middlewares\Auth;
use middlewares\Admin;
use middlewares\Guest;

class Middleware
{
    const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
        'admin' => Admin::class
    ];

    /**
     * @throws Exception
     */
    public static function resolve($key): void
    {
        if(! $key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if(! $middleware) {
            throw new Exception("No matching middleware found for key {$key}");
        }

        (new $middleware)->handle();
    }
}