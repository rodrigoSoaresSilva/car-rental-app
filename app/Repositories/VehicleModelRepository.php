<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\VehicleModel;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\Paginator;

class VehicleModelRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new VehicleModel());
    }
}
