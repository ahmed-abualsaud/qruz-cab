<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait HandleDriverAttributes
{
    protected function updateDriverStatus($driver_id, $status)
    {
        $response = Http::post('http://localhost:8000/rest/driver/update', [
            'id' => $driver_id,
            'cab_status' => $status
        ])->throw();
    }

    protected function driverToken($driver_id)
    {
        return Http::get('http://localhost:8000/rest/driver/'.$driver_id.'/device/id')->throw();
    }

    protected function driversToken(array $drivers_ids)
    {
        $response = Http::get('http://localhost:8000/rest/drivers/device/id', [
            'drivers_ids' => $drivers_ids,
        ])->throw();
    }
}