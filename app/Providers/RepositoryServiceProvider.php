<?php

namespace App\Providers;


use App\Repository\Mutations\CabRequestRepositoryInterface;
use App\Repository\Mutations\UserRepositoryInterface;
use App\Repository\Mutations\DriverRepositoryInterface;

use App\Repository\Eloquent\Mutations\CabRequestRepository;
use App\Repository\Eloquent\Mutations\UserRepository;
use App\Repository\Eloquent\Mutations\DriverRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        # ---------------------------------- MUTATIONS -----------------------------------

        $this->app->bind(CabRequestRepositoryInterface::class, CabRequestRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DriverRepositoryInterface::class, DriverRepository::class);
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
