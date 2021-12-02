<?php

namespace App\Traits;

use App\Models\User;

trait HandleUserAttributes
{

    protected function userToken($id)
    {
        return User::select('id', 'device_id')
            ->where('id', $id)
            ->pluck('device_id')
            ->toArray();
    }
}