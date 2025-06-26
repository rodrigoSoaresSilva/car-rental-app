<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait QueryBuilderTrait
{
    protected Builder $query;
    protected Model $model;

    public function newQuery(Model $model): Builder
    {
        $this->model = $model;
        return $this->query = $model->newQuery();
    }

    public function setSpecificFields(Builder $query, array $fields): self
    {
        $this->query = $this->query->select($fields);

        return $this;
    }

    public function setWithFilter(Builder $query, array $filters): self
    {
        foreach ($filters as $filter) {
            [$column, $operator, $value] = explode(':', $filter);

            if (in_array($column, $this->model->getFillable())) {
                $this->query = $this->query->where($column, $operator, $value);
            }
        }

        return $this;
    }

    public function setWithRelationship(Builder $query, string $model): self
    {
        $this->query = $this->query->with($model);

        return $this;
    }

    public function setWithRelationshipFields(Builder $query, string $model, array $fields): self
    {
        $this->query->with([$model => function ($query) use ($fields) {
            $query->select($fields);
        }]);

        return $this;
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->query->paginate($perPage);
    }

    public function get(): Collection
    {
        return $this->query->get();
    }
}
