<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name'                   => 'required',
            'price'                  => 'required|numeric|digits:5',
            'description'            => 'required',
            'subscription_category'  => 'required',
            'subscription_status'    => 'required',
            'request_allowed'        => 'required|digits:2',
            'avatar'                 => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'avatar.required'  => 'Avatar is required.',
        ];
    }
}
