<?php

/*
 * Front controller de PRODUCTION.
 *
 * Copie par .cpanel.yml vers public_html/index.php. Identique a
 * public/index.php, mais les chemins pointent vers ~/laravel/ au lieu de
 * ../ : sur le serveur, public_html/ et laravel/ sont deux dossiers freres.
 *
 * Ne pas utiliser en local.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../laravel/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

// Racine publique reelle.
//
// Par defaut, public_path() vaut ~/laravel/public, qui n'existe pas dans cette
// arborescence : le code applicatif est dans ~/laravel et la racine web dans
// ~/public_html. Sans cette ligne, tout ce qui passe par public_path() echoue
// — notamment le manifeste Vite, d'ou un « Vite manifest not found » sur
// chaque page.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
