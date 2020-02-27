<?php

namespace App\Http\Controllers\Api;

use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Class ProductController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 27, 2020
 * @project   reloop
 */
class ProductController extends Controller
{
    private $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Method: productCategoriesList
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function productCategoriesList()
    {
        $productCategoriesList = $this->productService->categoriesList();
        if($productCategoriesList){

            return ResponseHelper::jsonResponse(
                Config::get('constants.PRODUCT_CATEGORY_SUCCESS'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                $productCategoriesList
            );
            return ResponseHelper::jsonResponse(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                $productCategoriesList
            );
        }
    }
}
