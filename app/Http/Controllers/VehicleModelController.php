<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use App\Traits\HandlesModelNotFound;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class VehicleModelController extends Controller
{
    use HandlesModelNotFound;

    private $vehicle_model;
    private $uploadImagePath = 'images/vehicle_models';
    private $notFoundMessage = 'Vehicle Model not found.';

    public function __construct(VehicleModel $vehicle_model){
        $this->vehicle_model = $vehicle_model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicle_models = $this->vehicle_model->with('brand')->get();

        return response()->json(
            [
                'data' => $vehicle_models
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->vehicle_model->rules(), $this->vehicle_model->feedback());

        $image = $request->file('image');
        $imageUrn = $image->store($this->uploadImagePath, 'public');

        $newVehicleModel = [
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'image' => $imageUrn,
            'num_doors' => $request->num_doors,
            'num_seats' => $request->num_seats,
            'airbag' => $request->airbag,
            'abs_brakes' => $request->abs_brakes
        ];

        return response()->json(
            [
                'data' => $this->vehicle_model->create($newVehicleModel)
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $vehicle_model = $this->findOrFailWithResponse(VehicleModel::with('brand'), $id, $this->notFoundMessage);
        
        if ($vehicle_model instanceof JsonResponse) {
            return $vehicle_model;
        }

        return response()->json(['data' => $vehicle_model], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $vehicle_model = $this->findOrFailWithResponse(VehicleModel::class, $id, $this->notFoundMessage);
        
        if ($vehicle_model instanceof JsonResponse) {
            return $vehicle_model;
        }

        $rules = $request->isMethod('patch')
                            ? collect($vehicle_model->rules())->only(array_keys($request->all()))->all()
                            : $vehicle_model->rules();

        $updated_vehicle_model = $request->validate($rules, $this->vehicle_model->feedback());

        if ($request->hasFile('image')) {
            $oldImage = $vehicle_model->image;
            $updated_vehicle_model['image'] = $request->file('image')->store($this->uploadImagePath, 'public');
        }
        
        $vehicle_model->update($updated_vehicle_model);

        if (!empty($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        return response()->json(['data' => $vehicle_model], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $vehicle_model = $this->findOrFailWithResponse(VehicleModel::class, $id, $this->notFoundMessage);
        
        if ($vehicle_model instanceof JsonResponse) {
            return $vehicle_model;
        }

        $oldImage = $vehicle_model->image;

        $vehicle_model->delete();

        Storage::disk('public')->delete($oldImage);

        return response()->noContent();
    }
}
