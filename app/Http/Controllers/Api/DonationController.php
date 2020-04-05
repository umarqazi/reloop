<?php

namespace App\Http\Controllers\Api;

use App\Forms\Donation\DonationProductForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\DonationCategoryService;
use App\Services\DonationProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Class DonationController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 06, 2020
 * @project   reloop
 */
class DonationController extends Controller
{
    /**
     * Property: donationCategoryService
     *
     * @var DonationCategoryService
     */
    private $donationCategoryService;
    /**
     * Property: donationProductService
     *
     * @var DonationProductService
     */
    private $donationProductService;

    /**
     * DonationController constructor.
     * @param DonationCategoryService $donationCategoryService
     * @param DonationProductService $donationProductService
     */
    public function __construct(DonationCategoryService $donationCategoryService, DonationProductService $donationProductService)
    {
        $this->donationCategoryService = $donationCategoryService;
        $this->donationProductService = $donationProductService;
    }

    /**
     * Method: donationCategories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function donationCategories()
    {
        $donationCategories = $this->donationCategoryService->getAll();
        return ResponseHelper::jsonResponse(
            Config::get('constants.DONATION_CATEGORIES_LIST'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $donationCategories
        );
    }

    /**
     * Method: donationProducts
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function donationProducts(Request $request)
    {
        $donationProductForm = new DonationProductForm();
        $donationProductForm->loadFromArray($request->all());
        $donationProducts = $this->donationProductService->donationProducts($donationProductForm);

        return ResponseHelper::jsonResponse(
            $donationProducts['message'],
            $donationProducts['code'],
            $donationProducts['status'],
            $donationProducts['data']
        );
    }
}
