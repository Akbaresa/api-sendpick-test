<?php

use Illuminate\Filesystem\Filesystem;

$app = Illuminate\Foundation\Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'auth.bearer' => \App\Http\Middleware\AuthenticateWithBearerToken::class,
            'auth.bearer.admin' => \App\Http\Middleware\AuthenticateAdminBearer::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->create();

$app->singleton('files', function () {
    return new Filesystem;
});

return $app;
