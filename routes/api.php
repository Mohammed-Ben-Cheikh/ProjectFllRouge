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

    // Routes publiques
    Route::get('/riads', [RiadController::class, 'index']);
    Route::get('/riads/images', [RiadController::class, 'images']);
    Route::get('/riads/{slug}', [RiadController::class, 'show']);
    // Route::get('/riads/{slug}/avis', [AvisController::class, 'findByRiad']);
    Route::get('/riads/{slug}/services', [ServiceController::class, 'findByRiad']);

    Route::get('/villes', [VilleController::class, 'index']);
    Route::get('/villes/{slug}', [VilleController::class, 'show']);
    // Route::get('/villes/{slug}/avis', [AvisController::class, 'findByVille']);
    Route::get('/villes/{slug}/riads', [RiadController::class, 'findByVille']);
    Route::get('/villes/{slug}/services', [ServiceController::class, 'findByVille']);

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{slug}', [ServiceController::class, 'show']);
    Route::get('/services/{slug}/avis', [AvisController::class, 'findByService']);

    Route::get('/chambres', [ChambreController::class, 'index']);
    Route::get('/riads/{slug}/chambres', [ChambreController::class, 'findByRiad']);
    Route::get('/chambres/{slug}', [ChambreController::class, 'show']);
    // Route::get('/chambres/{slug}/avis', [AvisController::class, 'findByChambre']);

    // Routes sécurisées
    Route::middleware('auth:api')->group(function () {

        // Déconnexion
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('image', [AuthController::class, 'updateImage']);

        // // Routes protégées pour les administrateurs
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            // Routes pour les entreprises
            Route::get('/entreprises', [EntrepriseController::class, 'index']);
            Route::delete('/entreprises/{slug}', [EntrepriseController::class, 'destroy']);
            Route::post('/entreprises/{slug}/status', [EntrepriseController::class, 'updateStatus']);

            // Routes pour les riads
            Route::get('/riads', [RiadController::class, 'index']);
            Route::delete('/riads/{slug}', [RiadController::class, 'destroy']);
            Route::post('/riads/{slug}/status', [RiadController::class, 'updateStatus']);

            // Routes pour les villes
            Route::get('/villes', [VilleController::class, 'index']);
            Route::post('/villes', [VilleController::class, 'store']);
            Route::put('/villes/{slug}', [VilleController::class, 'update']);
            Route::delete('/villes/{slug}', [VilleController::class, 'destroy']);

            // Routes pour les avis des villes
            Route::get('/avis', [AvisController::class, 'indexVilles']);
            Route::delete('/avis/{slug}', [AvisController::class, 'destroy']);
            Route::post('/avis/{id}/status/{status}', [AvisController::class, 'updateStatus']);
        });

        // routes protégées pour les propriétaires
        Route::middleware('role:owner')->prefix('owner')->group(function () {
            Route::get('/villes', [VilleController::class, 'index']);

            Route::post('/employes', [EmployeController::class, 'store']);
            Route::get('/employes', [EmployeController::class, 'findUser']);
            Route::put('/employes/{slug}', [EmployeController::class, 'update']);
            Route::delete('/employes/{slug}', [EmployeController::class, 'destroy']);

            Route::post('/entreprises', [EntrepriseController::class, 'store']);
            Route::get('/entreprises', [EntrepriseController::class, 'findByUser']);
            Route::post('/entreprises/{slug}', [EntrepriseController::class, 'update']);
            Route::delete('/entreprises/{slug}', [EntrepriseController::class, 'destroy']);

            Route::get('/riads', [RiadController::class, 'findByUser']);
            Route::post('/riads', [RiadController::class, 'store']);
            Route::put('/riads/{slug}', [RiadController::class, 'update']);
            Route::delete('/riads/{slug}', [RiadController::class, 'destroy']);
        });


        // routes protégées pour les employés
        Route::middleware('role:employee')->prefix('employee')->group(function () {
            Route::get('/riads', [RiadController::class, 'findByEmployee']);

            Route::get('/services', [ServiceController::class, 'findByEmployee']);
            Route::post('/services', [ServiceController::class, 'store']);
            Route::put('/services/{slug}', [ServiceController::class, 'update']);
            Route::post('/services/{slug}', [ServiceController::class, 'updateStatus']);
            Route::delete('/services/{slug}', [ServiceController::class, 'destroy']);

            Route::get('/chambres', [ChambreController::class, 'findByEmployee']);
            Route::post('/chambres', [ChambreController::class, 'store']);
            Route::put('/chambres/{slug}', [ChambreController::class, 'update']);
            Route::post('/chambres/{slug}', [ChambreController::class, 'updateStatus']);
            Route::delete('/chambres/{slug}', [ChambreController::class, 'destroy']);

            Route::get('/riads/reservations/chambres', [ReservationController::class, 'findByRiadForChambres']);
            Route::get('/riads/reservations/services', [ReservationController::class, 'findByRiadForServices']);
            Route::post('/reservations/{invoice}/type/{type}', [ReservationController::class, 'updateStatus']);

            Route::get('/riads/payments', [PaiementController::class, 'index']);
            Route::post('/riad/payment-receipts/{invoice}/status', [PaiementController::class, 'updateStatus']);
        });

        // routes protégées pour les touristes
        Route::middleware('role:tourist')->prefix('tourist')->group(function () {
            Route::post('/become-owner' , [AuthController::class, 'becomeOwner']);
            // Routes pour les réservations des chambres
            Route::post('/reservations', [ReservationController::class, 'store']);
            Route::post('/reservations/{invoice}/status', [ReservationController::class, 'updateStatus']);
            Route::delete('/reservations/{slug}', [ReservationController::class, 'destroy']);
            Route::get('/reservations', [ReservationController::class, 'findByUser']);
            Route::get('/chambres/{slug}/reservations', [ReservationController::class, 'findByChambre']);

            // Routes pour les réservations des services
            Route::post('/reservations/service', [ReservationController::class, 'storeServiceReservation']);
            Route::post('/reservations/service/{invoice}/status', [ReservationController::class, 'updateServiceReservationStatus']);
            Route::delete('/reservations/service/{slug}', [ReservationController::class, 'destroyServiceReservation']);
            Route::get('/reservations/service', [ReservationController::class, 'findServiceReservationByUser']);
            Route::get('/services/{slug}/reservations', [ReservationController::class, 'findByService']);

            //route pour le paiement
            Route::post('/reservation/upload-payment-receipt', [PaiementController::class, 'store']);

            // Routes pour les favoris
            Route::post('/favoris', [FavorisController::class, 'store']);
            Route::delete('/favoris/{slug}', [FavorisController::class, 'destroy']);
            Route::get('/users/{username}/favoris', [FavorisController::class, 'findByUser']);

            // Routes pour les avis
            // Route::post('/avis/chambres', [AvisController::class, 'storeByChambre']);
            // Route::post('/avis/services', [AvisController::class, 'storeByService']);
            // Route::post('/avis/riads', [AvisController::class, 'storeByRiad']);

            // Route::delete('/avis/chambres/{id}', [AvisController::class, 'destroyByChambre']);
            // Route::delete('/avis/riads/{id}', [AvisController::class, 'destroyByRiad']);
            // Route::delete('/avis/services/{id}', [AvisController::class, 'destroyByService']);

            // Route::get('/mes-avis-chambres', [AvisController::class, 'findByUserChambres']);
            // Route::get('/mes-avis-services', [AvisController::class, 'findByUserServices']);
            // Route::get('/mes-avis-riads', [AvisController::class, 'findByUserRiads']);

            // Route::delete('/avis/villes/{id}', [AvisController::class, 'destroyByVille']);
            // Route::post('/avis/villes', [AvisController::class, 'storeByVille']);
            // Route::get('/mes-avis-villes', [AvisController::class, 'findByUserVilles']);

        });
    });
});
