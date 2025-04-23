<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\data\AvisRepositoryData;
use App\Repositories\data\RiadRepositoryData;
use App\Repositories\data\UserRepositoryData;
use App\Repositories\Contracts\AvisRepository;
use App\Repositories\Contracts\RiadRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\data\ImageRepositoryData;
use App\Repositories\data\VilleRepositoryData;
use App\Repositories\Contracts\ImageRepository;
use App\Repositories\Contracts\VilleRepository;
use App\Repositories\data\ChambreRepositoryData;

use App\Repositories\data\EmployeRepositoryData;
use App\Repositories\data\FavorisRepositoryData;
use App\Repositories\data\ServiceRepositoryData;
use App\Repositories\Contracts\ChambreRepository;
use App\Repositories\Contracts\EmployeRepository;
use App\Repositories\Contracts\FavorisRepository;
use App\Repositories\Contracts\ServiceRepository;
use App\Repositories\data\PaiementRepositoryData;
use App\Repositories\Contracts\PaiementRepository;
use App\Repositories\data\EntrepriseRepositoryData;
use App\Repositories\Contracts\EntrepriseRepository;
use App\Repositories\data\ReservationRepositoryData;

use App\Repositories\Contracts\ReservationRepository;
use App\Repositories\Data\AuthControllerRepositoryData;
use App\Repositories\Contracts\AuthControllerRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthControllerRepository::class, AuthControllerRepositoryData::class);
        $this->app->bind(EntrepriseRepository::class, EntrepriseRepositoryData::class);
        $this->app->bind(VilleRepository::class, VilleRepositoryData::class);
        $this->app->bind(RiadRepository::class, RiadRepositoryData::class);
        $this->app->bind(UserRepository::class, UserRepositoryData::class);
        $this->app->bind(ServiceRepository::class, ServiceRepositoryData::class);
        $this->app->bind(ReservationRepository::class, ReservationRepositoryData::class);
        $this->app->bind(PaiementRepository::class, PaiementRepositoryData::class);
        $this->app->bind(ImageRepository::class, ImageRepositoryData::class);
        $this->app->bind(FavorisRepository::class, FavorisRepositoryData::class);
        $this->app->bind(EmployeRepository::class, EmployeRepositoryData::class);
        $this->app->bind(ChambreRepository::class, ChambreRepositoryData::class);
        $this->app->bind(AvisRepository::class, AvisRepositoryData::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
