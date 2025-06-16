<?php

namespace App\Services;

use App\Models\Brand;
use App\Repositories\VehicleModelRepository;
use Illuminate\Http\Request;

class VehicleModelService
{
    public $vehicleModelRepository;

    public function __construct(VehicleModelRepository $vehicleModelRepository)
    {
        $this->vehicleModelRepository = $vehicleModelRepository;
    }

    public function getVehicleModels(Request $request)
    {
        if ($request->filled('brand_fields')) {
            $brandFields = explode(',', $request->get('brand_fields'));

            // Ensure only allowed fields are selected from 'brand'
            $safeBrandFields = array_intersect($brandFields, (new Brand())->getFillable());

            if (!empty($safeBrandFields)) {
                // Ensure the foreign key 'id' is always included to maintain relationships
                if (!in_array('id', $safeBrandFields)) {
                    $safeBrandFields[] = 'id';
                }

                $this->vehicleModelRepository->setWithRelationshipFields('brand', $safeBrandFields);
            }
        } else {
            $this->vehicleModelRepository->setWithRelationship('brand');
        }

        // Allow selecting specific columns for the main model
        if ($request->filled('fields')) {
            $fields = explode(',', $request->get('fields'));
            $safeFields = array_intersect($fields, $this->vehicleModelRepository->model->getFillable());

            if (!empty($safeFields)) {
                if (!in_array('id', $safeFields)) {
                    $safeFields[] = 'id';
                }

                $this->vehicleModelRepository->setSpecificFields($safeFields);
            }
        }

        // Apply dynamic filters using where conditions
        if ($request->filled('filters')) {
            $filters = explode(',', $request->get('filters'));

            $this->vehicleModelRepository->setWithFilter($filters);
        }

        $perPage = $request->input('per_page', 10);

        return $this->vehicleModelRepository->getModelsPaginated($perPage);
    }
}
