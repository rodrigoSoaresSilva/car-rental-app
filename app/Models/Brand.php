<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'image'];

    public function vehicleModels(){
        return $this->hasMany('App\Models\VehicleModel');
    }

    /**
     * Get the validation rules for the model.
     *
     * This method defines the validation rules used when creating or updating 
     * a brand. It ensures that the 'name' field is required and unique, 
     * and that the 'image' field is required and must be a PNG file.
     *
     * @return array The validation rules.
     */
    public function rules(): array {
        return [
            'name' => 'required|unique:brands,name,'.$this->id.'|min:3',
            'image' => 'required|file|mimes:png'
        ];
    }

    /**
     * Get the validation error messages.
     *
     * This method returns an array of custom error messages 
     * for validation failures. It provides user-friendly messages 
     * for required fields and unique constraints.
     *
     * @return array The validation error messages.
     */
    public function feedback(): array {
        return [
            'required' => 'The :attribute field is required.',
            'name.unique' => 'The brand name already exists.',
            'name.min' => 'The brand name must be at least 3 characters long.',
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be in PNG format.'
        ];
    }

}
