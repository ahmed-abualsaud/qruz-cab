<?php

namespace App\GraphQL\Mutations;

use App\Repository\Eloquent\Mutations\DriverRepository;

class DriverResolver 
{
    private $driverRepository;

    public function  __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function login($_, array $args)
    {
        return $this->driverRepository->login($args);
    }
}