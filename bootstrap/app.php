<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'active.provider' => \App\Http\Middleware\ActiveProviderMiddleware::class,
            'locale' => \App\Http\Middleware\SetLocale::class,
        ]);
        // Aplicar middleware de idioma al grupo web
        $middleware->appendToGroup('web', 'locale');

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
