<?php

use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiadController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\ServiceController;

Route::prefix('v1')->group(function () {

    // Authentification
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/account/activate', [AuthController::class, 'activateAccount']);
    Route::post('/password-reset', [AuthController::class, 'sendResetLink']);
    Route::post('/password-reset/confirm', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:api')->group(function () {

        // Déconnexion
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('image', [AuthController::class, 'updateImage']);

        // Routes protégées pour les administrateurs
        Route::middleware('role:admin')->group(function () {

            // Routes pour les entreprises
            Route::get('/entreprises', [EntrepriseController::class, 'index']);


            Route::get('/entreprises/{slug}', [EntrepriseController::class, 'show']);
            Route::delete('/entreprises/{slug}', [EntrepriseController::class, 'destroy']);
            Route::put('/entreprises/{slug}', [EntrepriseController::class, 'update']);
            Route::post('/image/entreprises/{slug}', [EntrepriseController::class, 'addImage']);

            // Routes pour les riads
            Route::get('/riads', [RiadController::class, 'index']);
            Route::post('/riads', [RiadController::class, 'store']);
            Route::get('/admin/riads/{slug}', [RiadController::class, 'findByEntreprise']);
            Route::get('/riads/{slug}', [RiadController::class, 'show']);
            Route::delete('/riads/{slug}', [RiadController::class, 'destroy']);
            Route::put('/riads/{slug}', [RiadController::class, 'update']);

            // Routes pour les villes
            Route::get('/villes', [VilleController::class, 'index']);
            Route::post('/villes', [VilleController::class, 'store']);
            Route::get('/villes/{slug}', [VilleController::class, 'show']);
            Route::delete('/villes/{slug}', [VilleController::class, 'destroy']);
            Route::put('/villes/{slug}', [VilleController::class, 'update']);

            // Routes pour les paiements
            Route::get('/paiements', [PaiementController::class, 'index']);
            Route::post('/paiements', [PaiementController::class, 'store']);
            Route::get('/paiements/{slug}', [PaiementController::class, 'show']);
            Route::put('/paiements/{slug}', [PaiementController::class, 'update']);
            Route::delete('/paiements/{slug}', [PaiementController::class, 'destroy']);
            Route::get('/reservations/{slug}/paiements', [PaiementController::class, 'findByReservation']);
            Route::get('/users/{slug}/paiements', [PaiementController::class, 'findByUser']);

            // Routes pour les réservations
            Route::get('/reservations', [ReservationController::class, 'index']);
            Route::post('/reservations', [ReservationController::class, 'store']);
            Route::get('/reservations/{slug}', [ReservationController::class, 'show']);
            Route::put('/reservations/{slug}', [ReservationController::class, 'update']);
            Route::delete('/reservations/{slug}', [ReservationController::class, 'destroy']);
            Route::get('/users/{slug}/reservations', [ReservationController::class, 'findByUser']);
            Route::get('/chambres/{slug}/reservations', [ReservationController::class, 'findByChambre']);
            Route::get('/reservations/status/{status}', [ReservationController::class, 'findByStatus']);

            // Routes pour les chambres
            Route::get('/chambres', [ChambreController::class, 'index']);
            Route::post('/chambres', [ChambreController::class, 'store']);
            Route::get('/chambres/{slug}', [ChambreController::class, 'show']);
            Route::put('/chambres/{slug}', [ChambreController::class, 'update']);
            Route::delete('/chambres/{slug}', [ChambreController::class, 'destroy']);
            Route::get('/riads/{slug}/chambres', [ChambreController::class, 'findByRiad']);

            // Routes pour les avis
            Route::get('/avis', [AvisController::class, 'index']);
            Route::post('/avis', [AvisController::class, 'store']);
            Route::get('/avis/{slug}', [AvisController::class, 'show']);
            Route::put('/avis/{slug}', [AvisController::class, 'update']);
            Route::delete('/avis/{slug}', [AvisController::class, 'destroy']);
            Route::get('/riads/{slug}/avis', [AvisController::class, 'findByRiad']);
            Route::get('/chambres/{slug}/avis', [AvisController::class, 'findByChambre']);
            Route::get('/services/{slug}/avis', [AvisController::class, 'findByService']);

            // Routes pour les favoris
            Route::get('/favoris', [FavorisController::class, 'index']);
            Route::post('/favoris', [FavorisController::class, 'store']);
            Route::get('/favoris/{slug}', [FavorisController::class, 'show']);
            Route::delete('/favoris/{slug}', [FavorisController::class, 'destroy']);
            Route::get('/users/{slug}/favoris', [FavorisController::class, 'findByUser']);
            Route::get('/riads/{slug}/favoris', [FavorisController::class, 'findByRiad']);

            // Routes pour les services
            Route::get('/services', [ServiceController::class, 'index']);
            Route::post('/services', [ServiceController::class, 'store']);
            Route::get('/services/{slug}', [ServiceController::class, 'show']);
            Route::put('/services/{slug}', [ServiceController::class, 'update']);
            Route::delete('/services/{slug}', [ServiceController::class, 'destroy']);
            Route::get('/entreprises/{slug}/services', [ServiceController::class, 'findByEntreprise']);

            // Routes pour les emoloyes
            Route::get('/employes', [EmployeController::class, 'index']);
            Route::post('/employes', [EmployeController::class, 'store']);
            Route::get('/employes/{slug}', [EmployeController::class, 'show']);
            Route::put('/employes/{slug}', [EmployeController::class, 'update']);
            Route::delete('/employes/{slug}', [EmployeController::class, 'destroy']);
            Route::get('/riads/{slug}/employes', [EmployeController::class, 'findByRiad']);
        });


        // routes protégées pour les propriétaires
        Route::middleware('role:owner')->group(function () {
            Route::post('/entreprises', [EntrepriseController::class, 'store']);
            Route::get('/owner/entreprises', [EntrepriseController::class, 'findByUser']);
            // Route::get('/entreprises', [EntrepriseController::class, 'index']);
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

});
