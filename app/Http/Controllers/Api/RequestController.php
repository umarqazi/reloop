<?php

namespace App\Http\Controllers\Api;

use App\Forms\Collection\CollectionRequestForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\MaterialCategoryService;
use App\Services\RequestService;
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
     * Property: requestService
     *
     * @var RequestService
     */
    private $requestService;

    /**
     * RequestController constructor.
     * @param MaterialCategoryService $materialCategoryService
     */
    public function __construct(MaterialCategoryService $materialCategoryService, RequestService $requestService)
    {
        $this->materialCategoryService = $materialCategoryService;
        $this->requestService = $requestService;
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

    /**
     * Method: collectionRequests
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function collectionRequests(Request $request)
    {
        $collectionRequestForm = new CollectionRequestForm();
        $collectionRequestForm->loadFromArray($request->all());

        $collectionRequest = $this->requestService->collectionRequest($collectionRequestForm);
        if(!empty($collectionRequest)){

            return ResponseHelper::jsonResponse(
                $collectionRequest['message'],
                $collectionRequest['code'],
                $collectionRequest['status'],
                $collectionRequest['data']
            );
        }
        return ResponseHelper::jsonResponse(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }
}
