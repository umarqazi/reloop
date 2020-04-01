<?php

namespace App\Http\Controllers\Api;

use App\Forms\User\ContactUsForm;
use App\Helpers\ResponseHelper;
use App\Services\ContactUsService;
use App\Services\PageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

/**
 * Class PageController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 30, 2020
 * @project   reloop
 */
class PageController extends Controller
{
    /**
     * Property: pageService
     *
     * @var PageService
     */
    private $pageService;

    /**
     * PageController constructor.
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Method: getPageContent
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPageContent()
    {
        $getPageContent = $this->pageService->getPageContent();

        return ResponseHelper::jsonResponse(
            $getPageContent['message'],
            $getPageContent['code'],
            $getPageContent['status'],
            $getPageContent['data']
        );
    }

    public function contactUs(Request $request)
    {
        $contactUsForm = new ContactUsForm();
        $contactUsForm->loadFromArray($request->all());
        $contactUs = App::make(ContactUsService::class)->contactUsDetails($contactUsForm);

        return ResponseHelper::jsonResponse(
            $contactUs['message'],
            $contactUs['code'],
            $contactUs['status'],
            $contactUs['data']
        );
    }
}
