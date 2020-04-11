<?php


namespace App\Services;


use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Page;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/**
 * Class PageService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 30, 2020
 * @project   reloop
 */
class PageService extends BaseService
{

    /**
     * Property: model
     *
     * @var Page
     */
    private $model;

    public function __construct(Page $model)
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
     * Method: getPageContent
     *
     * @return array
     */
    public function getPageContent()
    {
        $routeName = Route::currentRouteName();

        switch ($routeName){
            case ('terms-and-conditions'):
                $id = 1;
                break;
            case ('about-us'):
                $id = 2;
                break;
            default:
                $id = 2;
        }
        $pageData = $this->findById($id);
        if($pageData){

            return ResponseHelper::responseData(
                Config::get('constants.PAGE_CONTENT_SUCCESS'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                $pageData
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.PAGE_CONTENT_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $pageData
        );
    }
}
