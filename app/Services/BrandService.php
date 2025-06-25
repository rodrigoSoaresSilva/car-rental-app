<?php

namespace App\Services;

use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;

class BrandService
{
    public $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getBrands()
    {
        return $this->brandRepository->getAll();
    }

    public function getBrandsPaginated(Request $request)
    {
        $perPage = $request->input('per_page', 3);
        return $this->brandRepository->getPaginated($perPage);
    }
}
