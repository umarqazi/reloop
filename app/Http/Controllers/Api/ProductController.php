<?php

namespace App\Http\Controllers\Api;

use App\Forms\Product\CategoryProductsForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function categories()
    {
        $productCategoriesList = $this->productService->categoriesList();

        return ResponseHelper::jsonResponse(
            Config::get('constants.PRODUCT_CATEGORY_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $productCategoriesList
        );
    }

    public function categoryProducts(Request $request)
    {
        $categoryProductForm = new CategoryProductsForm();
        $categoryProductForm->loadFromArray($request->all());
        $categoryProducts = $this->productService->categoryProducts($categoryProductForm);

        if (!$categoryProducts->isEmpty()){

            return ResponseHelper::jsonResponse(
                Config::get('constants.PRODUCTS_SUCCESS'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                $categoryProducts
            );
        }
        return ResponseHelper::jsonResponse(
            Config::get('constants.RECORD_NOT_FOUND'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false
        );
    }
}
