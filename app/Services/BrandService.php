<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BrandService extends BaseService
{
    public function __construct(BrandRepository $brandRepository)
    {
        parent::__construct($brandRepository);
    }

    public function getAllBrands(): Collection
    {
        return $this->repository->getAll();
    }

    public function getBrandsPaginated(Request $request): LengthAwarePaginator
    {
        $query = $this->getNewQuery();

        return $this->getPaginated($query, $request);
    }
}
