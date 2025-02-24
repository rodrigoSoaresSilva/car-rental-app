<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HandlesModelNotFound
{
    /**
     * Searches for a model by ID and handles approaches.
     *
     * @param  string $model   Fully qualified model class name
     * @param  int    $id      ID of the resource
     * @param  string $message Custom error message
     * @return Model|JsonResponse
     */
    public function findOrFailWithResponse(string $model, int $id, string $message = 'Resource not found.'): Model|JsonResponse
    {
        try {
            return $model::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $message], Response::HTTP_NOT_FOUND);
        }
    }
}
