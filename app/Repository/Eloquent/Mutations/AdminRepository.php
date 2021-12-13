<?php

namespace App\Repository\Eloquent\Mutations;

use Illuminate\Support\Facades\Http;

class AdminRepository
{
    public function login(array $args)
    {
        $response = Http::post('http://localhost:8000/rest/admin/login', $args)->throw();

        DB::table('users_auth_tokens')->updateOrInsert([
            'user_type' => 'Admin',
            'user_id' => $response['data']['admin']['id']
        ], [
            'token' => $response['data']['access_token']
        ]);
    
        return $response['data'];
    }
}
