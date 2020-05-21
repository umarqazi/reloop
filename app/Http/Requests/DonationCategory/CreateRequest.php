<?php

namespace App\Http\Requests\DonationCategory;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateRequest
 *
 * @package   App\Http\Requests\DonationCategory
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     May 22, 2020
 * @project   reloop
 */
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
            'name'              => 'required',
            'status'            => 'required',
            'avatar'            => 'required'
        ];
    }

    /**
     * Method: messages
     *
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'avatar.required'  => 'Avatar is required.',
        ];
    }
}
