<?php

namespace App\GraphQL\Mutations;

use App\Repository\Eloquent\Mutations\UserRepository;
 
class UserResolver
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function create($_, array $args)
    {
        return $this->userRepository->create($args);
    }

    public function login($_, array $args)
    {
        return $this->userRepository->login($args);
    }

    public function socialLogin($_, array $args)
    {
        return $this->userRepository->socialLogin($args);
    }
}