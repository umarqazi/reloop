<?php


namespace App\Services;
use App\DonationProduct;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class DonationProductService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 06, 2020
 * @project   reloop
 */
class DonationProductService extends BaseService
{
    /**
     * Property: model
     *
     * @var DonationProduct
     */
    private $model;

    /**
     * DonationProductService constructor.
     * @param DonationProduct $model
     */
    public function __construct(DonationProduct $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() method.
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
     * Method: findByCategoryId
     *
     * @param $categoryId
     *
     * @return mixed
     */
    public function findByCategoryId($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->get();
    }

    /**
     * Method: donationProducts
     *
     * @param IForm $donationProductForm
     *
     * @return array
     */
    public function donationProducts(IForm $donationProductForm)
    {
        if($donationProductForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $donationProductForm->errors()
            );
        }

        $donationProducts = $this->findByCategoryId($donationProductForm->category_id);
        if(!$donationProducts->isEmpty()){

            return ResponseHelper::responseData(
                Config::get('constants.DONATION_PRODUCTS_LIST'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                $donationProducts
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.DONATION_PRODUCTS_FAIL'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }
}
