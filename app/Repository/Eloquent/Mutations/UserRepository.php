<?php

namespace App\Repository\Eloquent\Mutations;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function create(array $args)
    { 
        $response = Http::post('http://localhost:8000/rest/user/create', $args)->throw();

        if(array_key_exists('errors', $response->json())) {
            return $response['errors'];
        }
        DB::table('users_auth_tokens')->updateOrInsert([
            'user_type' => 'User',
            'user_id' => $response['user']['id']
        ], [
            'token' => $response['access_token']
        ]);
    
        return $response;
    }

    public function login(array $args)
    {
        $response = Http::post('http://localhost:8000/rest/user/login', $args)->throw();

        if(array_key_exists('errors', $response->json())) {
            return $response['errors'];
        }
        DB::table('users_auth_tokens')->updateOrInsert([
            'user_type' => 'User',
            'user_id' => $response['user']['id']
        ], [
            'token' => $response['access_token']
        ]);
    
        return $response;
    }

    public function socialLogin($_, array $args)
    {
        $response = Http::post('http://localhost:8000/rest/user/social/login', $args)->throw();

        if(array_key_exists('errors', $response->json())) {
            return $response['errors'];
        }
        DB::table('users_auth_tokens')->updateOrInsert([
            'user_type' => 'User',
            'user_id' => $response['user']['id']
        ], [
            'token' => $response['access_token']
        ]);
    
        return $response;
    }
}
