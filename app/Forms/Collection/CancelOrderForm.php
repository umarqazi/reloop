<?php


namespace App\Forms\Collection;


use App\Forms\BaseForm;

/**
 * Class CancelOrderForm
 *
 * @package   App\Forms\Collection
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Jun 18, 2020
 * @project   reloop
 */
class CancelOrderForm extends BaseForm
{

    public $order_id;
    public $order_type;

    public function toArray()
    {
        return [
            'order_id'    => $this->order_id,
            'order_type'  => $this->order_type,
        ];
    }

    public function rules()
    {
        return [
            'order_id'    => 'required',
            'order_type'  => 'required',
        ];
    }
}
