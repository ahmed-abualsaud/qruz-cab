<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait HandleUserAttributes
{
    protected function userToken($user_id)
    {
        return Http::get('http://localhost:8000/rest/user/'.$user_id.'/device/id')->throw();
    }
}