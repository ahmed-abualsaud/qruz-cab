<?php

namespace App\Repository;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{
    public function create(array $args);
    public function update(array $args);
    public function destroy(array $args);
}