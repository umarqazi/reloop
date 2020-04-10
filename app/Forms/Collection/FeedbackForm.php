<?php


namespace App\Forms\Collection;
use App\Forms\BaseForm;

/**
 * Class FeedbackForm
 *
 * @package   App\Forms\Collection
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 11, 2020
 * @project   reloop
 */
class FeedbackForm extends BaseForm
{
    public $feedback;
    public $order_id;
    public $order_type;
    public $additional_comments;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'feedback'              => $this->feedback,
            'order_id'              => $this->order_id,
            'order_type'            => $this->order_type,
            'additional_comments'   => $this->additional_comments,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'feedback'     => 'required',
            'order_id'     => 'required',
            'order_type'   => 'required'
        ];
    }
}
