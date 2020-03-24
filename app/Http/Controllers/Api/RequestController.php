<?php

namespace App\Http\Controllers\Api;

use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\MaterialCategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Class RequestController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 24, 2020
 * @project   reloop
 */
class RequestController extends Controller
{
    /**
     * Property: materialCategoryService
     *
     * @var MaterialCategoryService
     */
    private $materialCategoryService;

    /**
     * RequestController constructor.
     * @param MaterialCategoryService $materialCategoryService
     */
    public function __construct(MaterialCategoryService $materialCategoryService)
    {
        $this->materialCategoryService = $materialCategoryService;
    }

    /**
     * Method: materialCategories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function materialCategories()
    {
        $materialCategories = $this->materialCategoryService->getAll();

        return ResponseHelper::jsonResponse(
            Config::get('constants.MATERIAL_CATEGORY_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $materialCategories
        );
    }
}
