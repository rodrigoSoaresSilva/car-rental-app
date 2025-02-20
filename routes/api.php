<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RentalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResources([
    'brand' => BrandController::class,
    'vehicle-model' => VehicleModelController::class,
    'car' => CarController::class,
    'client' => ClientController::class,
    'rental' => RentalController::class,
]);