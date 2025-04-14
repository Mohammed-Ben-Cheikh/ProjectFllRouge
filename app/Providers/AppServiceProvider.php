<?php

namespace App\Providers;

use App\Repositories\Contracts\EntrepriseRepository;
use App\Repositories\Contracts\RiadRepository;
use App\Repositories\data\EntrepriseRepositoryData;
use App\Repositories\data\RiadRepositoryData;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
