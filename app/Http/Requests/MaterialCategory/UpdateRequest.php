<?php

namespace App\Http\Requests\MaterialCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                 => 'required',
            'status'               => 'required',
            'quantity'             => 'required',
            'unit'                 => 'required',
            'reward_points'        => 'required',
            'co2_emission_reduced' => 'required',
            'trees_saved'          => 'required',
            'oil_saved'            => 'required',
            'electricity_saved'    => 'required',
            'natural_ores_saved'   => 'required',
            'water_saved'          => 'required',
            'landfill_space_saved' => 'required',
        ];
    }
}
