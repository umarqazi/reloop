<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class UpdateLocationForm*
 */
class UpdateLocationForm extends BaseForm
{
    public $user_id;
    public $latitude;
    public $longitude;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'user_id'        => $this->user_id,
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'user_id'          =>'required',
            'latitude'         =>'required',
            'longitude'        =>'required',
        ];
    }
}
