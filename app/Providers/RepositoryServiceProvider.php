<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BoatRepositoryInterface;
use App\Repositories\Contracts\BoatModelRepositoryInterface;
use App\Repositories\Contracts\ManufacturerRepositoryInterface;
use App\Repositories\BoatRepository;
use App\Repositories\BoatModelRepository;
use App\Repositories\ManufacturerRepository;
use App\Models\Boat;
use App\Models\BoatModel;
use App\Models\Manufacturer;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BoatRepositoryInterface::class, function ($app) {
            return new BoatRepository($app->make(Boat::class));
        });

        $this->app->bind(BoatModelRepositoryInterface::class, function ($app) {
            return new BoatModelRepository($app->make(BoatModel::class));
        });

        $this->app->bind(ManufacturerRepositoryInterface::class, function ($app) {
            return new ManufacturerRepository($app->make(Manufacturer::class));
        });
    }
}
