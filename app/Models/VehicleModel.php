<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $fillable = ['brand_id', 'name', 'image', 'num_doors', 'num_seats', 'airbag', 'abs_brakes'];

    public function brand(){
        return $this->belongsTo('App\Models\Brand');
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
            'brand_id' => 'exists:brands,id',
            'name' => 'required|unique:vehicle_models,name,'.$this->id.'|min:3',
            'image' => 'required|file|mimes:png',
            'num_doors' => 'required|integer|digits_between:1,5',
            'num_seats' => 'required|integer|digits_between:1,50',
            'airbag' => 'required|boolean',
            'abs_brakes' => 'required|boolean'
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
            'brand_id.exists' => 'The selected brand does not exist.',
            'name.unique' => 'The vehicle model name already exists.',
            'name.min' => 'The vehicle model name must be at least 3 characters long.',
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be in PNG format.',
            'num_doors.integer' => 'The number of doors must be an integer.',
            'num_doors.digits_between' => 'The number of doors must be between 1 and 5.',
            'num_seats.integer' => 'The number of seats must be an integer.',
            'num_seats.digits_between' => 'The number of seats must be between 1 and 50.',
            'airbag.boolean' => 'The airbag field must be true or false.',
            'abs_brakes.boolean' => 'The ABS brakes field must be true or false.',
        ];
    }
}
