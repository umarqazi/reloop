<?php


namespace App\Services;


use App\ContactUs;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class ContactUsService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 01, 2020
 * @project   reloop
 */
class ContactUsService extends BaseService
{
    /**
     * Property: model
     *
     * @var ContactUs
     */
    private $model;

    public function __construct(ContactUs $model)
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
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: contactUsDetails
     * 
     * @param IForm $contactUsForm
     *
     * @return array
     */
    public function contactUsDetails(IForm $contactUsForm)
    {
        if($contactUsForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $contactUsForm->errors()
            );
        }

        $this->model->create([
            'email' => $contactUsForm->email,
            'subject' => $contactUsForm->subject,
            'message' => $contactUsForm->message
        ]);

        return ResponseHelper::responseData(
            Config::get('constants.CONTACT_US_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            null
        );
    }
}
