<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\Paginator;

class BrandRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Brand());
    }
}
