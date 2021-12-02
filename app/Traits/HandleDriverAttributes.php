<?php

namespace App\Traits;

use App\Models\Driver;

trait HandleDriverAttributes
{
    protected function updateDriverStatus($driver_id, $status)
    {
        Driver::where('id', $driver_id)->update(['status' => $status]);
    }

    protected function driverToken($driver_id)
    {
        return Driver::select('id', 'device_id')
            ->where('id', $driver_id)
            ->pluck('device_id')
            ->toArray();
    }

    protected function driversToken(array $drivers_ids)
    {
        return Driver::select('id', 'device_id')
            ->whereIn('id', $drivers_ids)
            ->pluck('device_id')
            ->toArray();
    }
}