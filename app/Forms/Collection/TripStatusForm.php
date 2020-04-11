<?php


namespace App\Forms\Collection;
use App\Forms\BaseForm;

/**
 * Class TripStatusForm
 *
 * @package   App\Forms\Collection
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 11, 2020
 * @project   reloop
 */
class TripStatusForm extends BaseForm
{
    public $order_id;
    public $order_type;
    public $status_type;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'order_id'      => $this->order_id,
            'order_type'    => $this->order_type,
            'status_type'   => $this->status_type,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'order_id'      => 'required',
            'order_type'    => 'required|between:1,2',
            'status_type'   => 'required|between:1,2'
        ];
    }
}
