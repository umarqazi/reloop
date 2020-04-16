<?php


namespace App\Services;


use App\DriverCurrentLocation;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class DriverLocationService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 17, 2020
 * @project   reloop
 */
class DriverLocationService extends BaseService
{
    /**
     * Property: model
     *
     * @var DriverCurrentLocation
     */
    private $model;

    public function __construct(DriverCurrentLocation $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * Method: store
     *
     * @param IForm $form
     *
     * @return array|mixed
     */
    public function store(IForm $form)
    {
        if($form->fails())
        {
            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $form->errors()
            );
        }
        $driverId = auth()->id();
        $updateDriverLocation = $this->model->where('driver_id', $driverId)->first();
        if($updateDriverLocation){

            $updateDriverLocation->latitude   = $form->latitude;
            $updateDriverLocation->longitude  = $form->longitude;
            $updateDriverLocation->update();
        } else {

            $this->model->create([
                'driver_id'  => $driverId,
                'latitude'   => $form->latitude,
                'longitude'  => $form->longitude,
            ]);
        }
        return ResponseHelper::responseData(
            Config::get('constants.DRIVER_LOCATION'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            null
        );
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

}
