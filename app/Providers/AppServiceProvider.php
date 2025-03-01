<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BoatRepository;
use App\Repositories\Contracts\BoatRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BoatRepositoryInterface::class, BoatRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
