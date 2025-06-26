<?php

namespace App\Services;

use App\Models\Brand;
use App\Repositories\VehicleModelRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class VehicleModelService extends BaseService
{
    public function __construct(VehicleModelRepository $vehicleModelRepository)
    {
        parent::__construct($vehicleModelRepository);
    }

    public function getVehicleModels(Request $request): LengthAwarePaginator
    {
        $query = $this->getNewQuery();
        
        if ($request->filled('brand_fields')) {
            $brandFields = explode(',', $request->get('brand_fields'));

            // Ensure only allowed fields are selected from 'brand'
            $safeBrandFields = array_intersect($brandFields, (new Brand())->getFillable());

            if (!empty($safeBrandFields)) {
                // Ensure the foreign key 'id' is always included to maintain relationships
                if (!in_array('id', $safeBrandFields)) {
                    $safeBrandFields[] = 'id';
                }

                $this->setWithRelationshipFields($query, 'brand', $safeBrandFields);
            }
        } else {
            $this->setWithRelationship($query, 'brand');
        }

        return $this->getPaginated($query, $request);
    }
}
