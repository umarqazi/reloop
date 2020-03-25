<?php


namespace App\Services;


use App\Address;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class AddressService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 02, 2020
 * @project   reloop
 */
class AddressService extends BaseService
{
    /**
     * Property: model
     *
     * @var Address
     */
    private $model;

    public function __construct(Address $model)
    {
        $this->model = $model;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() mehtod.
    }

    /**
     * Method: storeAddress
     *
     *
     * @param array $data
     *
     * @return mixed
     */
    public function storeAddress(array $data)
    {
        return $this->model->create(
            $data
        );
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: updateOrCreate
     *
     * @param $address
     *
     * @return array
     */
    public function updateOrCreate($address)
    {
        if(!empty($address->id)){

            $findAddress = $this->findById($address->id);
            if($findAddress){

                $findAddress->id = $address->id;
                $findAddress->user_id = auth()->id();
                $findAddress->city_id = $address->city_id;
                $findAddress->district_id = $address->district_id;
                $findAddress->location = $address->location;
                $findAddress->latitude = $address->latitude;
                $findAddress->longitude = $address->longitude;
                $findAddress->type = $address->type;
                $findAddress->street = $address->street;
                $findAddress->no_of_bedrooms = $address->no_of_bedrooms;
                $findAddress->no_of_occupants = $address->no_of_occupants;
                $findAddress->floor = $address->floor;
                $findAddress->unit_number = $address->unit_number;
                $findAddress->update();

                $responseData = [
                    'message' => Config::get('constants.ADDRESS_UPDATE'),
                    'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                    'status' => true,
                    'data' => $findAddress
                ];
            } else {

                $responseData = [
                    'message' => Config::get('constants.INVALID_ADDRESS_ID'),
                    'code' => IResponseHelperInterface::FAIL_RESPONSE,
                    'status' => false,
                    'data' => null
                ];
            }
        } else{

            $newAddress = [
                'user_id'         => auth()->id(),
                'city_id'         => $address->city_id,
                'district_id'     => $address->district_id,
                'type'            => $address->type,
                'location'        => $address->location,
                'latitude'        => $address->latitude,
                'longitude'       => $address->longitude,
                'no_of_bedrooms'  => $address->no_of_bedrooms,
                'no_of_occupants' => $address->no_of_occupants,
                'street'          => $address->street,
                'floor'           => $address->floor,
                'unit_number'     => $address->unit_number,
            ];
            $saveAddress = $this->model->create($newAddress);
            $responseData = [
                'message' => Config::get('constants.ADDRESS_SAVED'),
                'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                'status' => true,
                'data' => $saveAddress
            ];
        }
        return $responseData;
    }
}
