<?php


namespace App\Forms\Collection;
use App\Forms\BaseForm;

/**
 * Class RecordWeightForm
 *
 * @package   App\Forms\Collection
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 09, 2020
 * @project   reloop
 */
class RecordWeightForm extends BaseForm
{
    public $request_collection;
    public $additional_comments;
    public $request_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'request_collection'  => $this->request_collection,
            'additional_comments' => $this->additional_comments,
            'request_id'          => $this->request_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'request_collection'  => 'required',
            'request_id'          => 'required'
        ];
    }
}
