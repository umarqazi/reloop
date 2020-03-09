<?php

namespace App\Http\Requests\Organization;

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
            'name'                => 'required',
            'email'               => 'required',
            'phone_number'        => 'required',
            'no_of_employees'     => 'required',
            'no_of_branches'      => 'required',
            'sector_id'           => 'required',
        ];
    }
}
