<?php

namespace App\Providers;

use App\Repositories\Contracts\EntrepriseRepository;
use App\Repositories\Contracts\RiadRepository;
use App\Repositories\Contracts\VilleRepository;
use App\Repositories\data\EntrepriseRepositoryData;
use App\Repositories\data\RiadRepositoryData;
use App\Repositories\data\VilleRepositoryData;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EntrepriseRepository::class, EntrepriseRepositoryData::class);
        $this->app->bind(RiadRepository::class, RiadRepositoryData::class);
        $this->app->bind(VilleRepository::class, VilleRepositoryData::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
