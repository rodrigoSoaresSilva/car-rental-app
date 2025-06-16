<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\VehicleModel;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\Paginator;

class VehicleModelRepository extends BaseRepository
{
    protected $queryF;

    public function __construct()
    {
        parent::__construct(new VehicleModel());

        $this->queryF = $this->model->newQuery();
    }

    public function setSpecificFields(array $fields): void
    {
        $this->queryF = $this->queryF->select($fields);
    }

    public function setWithFilter(array $filters): void
    {
        foreach ($filters as $filter) {
            [$column, $operator, $value] = explode(':', $filter);

            if (in_array($column, $this->model->getFillable())) {
                $this->queryF = $this->queryF->where($column, $operator, $value);
            }
        }
    }

    public function setWithRelationship(string $model): void
    {
        $this->queryF = $this->queryF->with($model);
    }

    public function setWithRelationshipFields(string $model, array $fields): void
    {
        $this->queryF->with([$model => function ($query) use ($fields) {
            $query->select($fields);
        }]);
    }

    public function getModelsPaginated(int $perPage = 10): Paginator
    {
        return $this->queryF->simplePaginate($perPage);
    }
}
