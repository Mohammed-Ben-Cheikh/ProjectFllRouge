<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
        //
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
