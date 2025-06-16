<?php

namespace App\Interfaces\Repository;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function getById(int $id): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): bool;
    public function remove(int $id): bool;
}
