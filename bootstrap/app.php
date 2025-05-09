<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\isStaff;
use App\Http\Middleware\IsGuest;
use App\Http\Middleware\IsLogin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isAdmin' => IsAdmin::class,
            'isStaff' => isStaff::class,
            'isGuest' => IsGuest::class,
            'isLogin' => IsLogin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
