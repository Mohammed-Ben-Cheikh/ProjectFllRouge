<?php

use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiadController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\EntrepriseController;

// Authentification
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/account/activate', [AuthController::class, 'activateAccount']);
Route::post('/password-reset', [AuthController::class, 'sendResetLink']);
Route::post('/password-reset/confirm', [AuthController::class, 'resetPassword']);


Route::middleware('auth:api')->group(function () {

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);


    // Routes protégées pour les administrateurs
    Route::middleware('role:admin')->group(function () {
        Route::get('/entreprises', [EntrepriseController::class, 'index']);
        Route::post('/entreprises', [EntrepriseController::class, 'store']);
        Route::get('/admin/entreprises', [EntrepriseController::class, 'findByUser']);
        Route::get('/entreprises/{slug}', [EntrepriseController::class, 'show']);
        Route::delete('/entreprises/{slug}', [EntrepriseController::class, 'destroy']);
        Route::put('/entreprises/{slug}', [EntrepriseController::class, 'update']);

        Route::get('/riads', [RiadController::class, 'index']);
        Route::post('/riads', [RiadController::class, 'store']);
        Route::get('/admin/riads/{slug}', [RiadController::class, 'findByEntreprise']);
        Route::get('/riads/{slug}', [RiadController::class, 'show']);
        Route::delete('/riads/{slug}', [RiadController::class, 'destroy']);
        Route::put('/riads/{slug}', [RiadController::class, 'update']);

        Route::get('/villes', [VilleController::class, 'index']);
        Route::post('/villes', [VilleController::class, 'store']);
        Route::get('/villes/{slug}', [VilleController::class, 'show']);
        Route::delete('/villes/{slug}', [VilleController::class, 'destroy']);
        Route::put('/villes/{slug}', [VilleController::class, 'update']);
    });


    // routes protégées pour les propriétaires
    Route::middleware('role:owner')->group(function () {
        //
    });


    // routes protégées pour les employés
    Route::middleware('role:employee')->group(function () {
        //
    });


    // routes protégées pour les touristes
    Route::middleware('role:tourist')->group(function () {
        //
    });
});
