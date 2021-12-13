<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait HandleAuthToken
{
    protected function getAuthToken($user_type, $user_id)
    {
        $authToken = DB::table('users_auth_tokens')
            ->select('token')
            ->where('user_type', $user_type)
            ->where('user_id', $user_id)
            ->first();

        if($authToken) {
            return $authToken->token;
        }

        return null;
    }
}