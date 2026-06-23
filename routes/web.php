<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\VehicleController;

// ========== ROUTES PUBLIQUES ==========
Route::get('/', [HomeController::class, 'index']);
Route::get('/machines-engins', [HomeController::class, 'machines'])->name('machines.engins');
Route::get('/vehicules-occasion', [HomeController::class, 'vehicules'])->name('vehicules.occasion');
Route::get('/vehicules-occasion/{id}', [HomeController::class, 'details'])->name('details');
Route::get('/actualite', [HomeController::class, 'actualite'])->name('actualite');
Route::get('/devis', [HomeController::class, 'devis'])->name('devis');

// ========== AUTHENTIFICATION ==========
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('connexion');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== ROUTES ADMIN (Protégées par middleware auth + isAdmin) ==========
Route::middleware(['auth', 'admin', 'verified'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Articles
    Route::prefix('admin/articles')->name('admin.articles.')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('index');
        Route::get('/create', [ArticleController::class, 'create'])->name('create');
        Route::post('/', [ArticleController::class, 'store'])->name('store');
        Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
        Route::put('/{article}', [ArticleController::class, 'update'])->name('update');
        Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('destroy');
    });

    // Marques
    Route::prefix('admin/brands')->name('admin.brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/', [BrandController::class, 'store'])->name('store');
        Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::put('/{brand}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('destroy');
    });

    // Véhicules
    Route::prefix('admin/vehicles')->name('admin.vehicles.')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('index');
        Route::get('/create', [VehicleController::class, 'create'])->name('create');
        Route::post('/', [VehicleController::class, 'store'])->name('store');
        Route::get('/{vehicle}/edit', [VehicleController::class, 'edit'])->name('edit');
        Route::put('/{vehicle}', [VehicleController::class, 'update'])->name('update');
        Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('destroy');
        Route::patch('/{vehicle}/toggle-availability', [VehicleController::class, 'toggleAvailability'])->name('toggle-availability');
    });
});

