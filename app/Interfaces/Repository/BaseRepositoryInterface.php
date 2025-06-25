<?php

namespace App\Interfaces\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function getById(int $id): ?Model;
    public function getAll(): Collection;
    public function getPaginated(int $perPage): LengthAwarePaginator;
    public function create(array $data): Model;
    public function update(int $id, array $data): bool;
    public function remove(int $id): bool;
}
