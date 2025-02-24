<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Traits\HandlesModelNotFound;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class BrandController extends Controller
{
    use HandlesModelNotFound;

    private $brand;
    private $uploadImagePath = 'images/brands';
    private $notFoundMessage = 'Brand not found.';

    public function __construct(Brand $brand){
        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = $this->brand->all();

        return response()->json(
            [
                'data' => $brands
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate($this->brand->rules(), $this->brand->feedback());

        $image = $request->file('image');
        $imageUrn = $image->store($this->uploadImagePath, 'public');

        $newBrand = [
            'name' => $request->name,
            'image' => $imageUrn
        ];

        return response()->json(
            [
                'data' => $this->brand->create($newBrand)
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Int $id)
    {
        $brand = $this->findOrFailWithResponse(Brand::class, $id, $this->notFoundMessage);
        
        if ($brand instanceof JsonResponse) {
            return $brand;
        }

        return response()->json(['data' => $brand], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $brand = $this->findOrFailWithResponse(Brand::class, $id, $this->notFoundMessage);
        
        if ($brand instanceof JsonResponse) {
            return $brand;
        }

        $rules = $request->isMethod('patch')
                            ? collect($brand->rules())->only(array_keys($request->all()))->all()
                            : $brand->rules();

        $updated_brand = $request->validate($rules, $this->brand->feedback());

        $updated_brand['name'] = null;

        if ($request->hasFile('image')) {
            $oldImage = $brand->image;
            $updated_brand['image'] = $request->file('image')->store($this->uploadImagePath, 'public');
        }
        
        $brand->update($updated_brand);

        if (!empty($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        return response()->json(['data' => $brand], Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Int $id)
    {
        $brand = $this->findOrFailWithResponse(Brand::class, $id, $this->notFoundMessage);
        
        if ($brand instanceof JsonResponse) {
            return $brand;
        }

        $oldImage = $brand->image;

        $brand->delete();

        Storage::disk('public')->delete($oldImage);

        return response()->json(['message' => 'Brand removed with success.'], Response::HTTP_NO_CONTENT);
    }
}
