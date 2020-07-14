<?php

namespace App\Http\Requests\Coupon;

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
            'code'     => 'required',
            'type'     => 'required',
            'amount'   => 'required',
            'apply_for_user'   => 'required',
            'coupon_user_type'   => 'required',
            'apply_for_category'   => 'required',
            'coupon_category_type'   => 'required',
            'max_usage_per_user'   => 'required',
            'max_usage_limit'   => 'required',
        ];
    }

}
