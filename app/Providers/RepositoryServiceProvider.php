<?php

namespace App\Providers;


use App\Repository\Mutations\CabRequestRepositoryInterface;

use App\Repository\Eloquent\Mutations\CabRequestRepository;

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
