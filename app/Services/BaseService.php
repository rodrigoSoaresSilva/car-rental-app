<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Traits\QueryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class BaseService
{
    use QueryBuilderTrait;

    public $repository;

    public function __construct(BaseRepository $respository)
    {
        $this->respository = $respository;
    }

    public function getAll(): Collection
    {
        return $this->respository->getAll();
    }

    public function getPaginated(Builder $query, Request $request)
    {
        $this->createQuery($query, $request);

        $perPage = $request->input('per_page', 2);//alterar para 10
        return $this->paginate($perPage);
    }

    public function getNewQuery(): Builder
    {
        return $this->newQuery($this->respository->model);
    }

    public function createQuery(Builder $query, Request $request)
    {
        // Allow selecting specific columns for the main model
        if ($request->filled('fields')) {
            $fields = explode(',', $request->get('fields'));
            $safeFields = array_intersect($fields, $this->respository->model->getFillable());

            if (!empty($safeFields)) {
                if (!in_array('id', $safeFields)) {
                    $safeFields[] = 'id';
                }

                $this->setSpecificFields($query, $safeFields);
            }
        }

        // Apply dynamic filters using where conditions
        if ($request->filled('filters')) {
            $filters = explode(',', $request->get('filters'));

            $this->setWithFilter($query, $filters);
        }
    }
}
