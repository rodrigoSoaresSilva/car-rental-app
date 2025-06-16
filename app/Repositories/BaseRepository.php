<?php

namespace App\Repositories;

use App\Interfaces\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->whereId($id)->update($data);
    }

    public function remove(int $id): bool
    {
        return $this->model->whereId($id)->destroy();
    }
}
