<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        // Le middleware `auth` redirige par défaut vers la route nommée `login`,
        // qui n'existe ici qu'en POST : la page de connexion est `connexion` (GET).
        // Sans cette ligne, tout accès invité à une route protégée renvoie un 405.
        $middleware->redirectGuestsTo(fn () => route('connexion'));

        // Derrière un tunnel (ngrok) ou un load balancer, la requête arrive en
        // HTTP : sans ça Laravel génère des URLs http:// sur une page https://.
        // Variable d'environnement SYSTÈME (pas .env : cette closure s'exécute
        // avant son chargement). Absente en production = aucun proxy de confiance.
        if ($proxies = env('TRUST_PROXIES')) {
            $middleware->trustProxies(at: $proxies === '*' ? '*' : explode(',', $proxies));
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
