<?php


namespace App\Services;


use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\PasswordChangeRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class PasswordChangeRequestService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 13, 2020
 * @project   reloop
 */
class PasswordChangeRequestService extends BaseService
{
    /**
     * Property: model
     *
     * @var PasswordChangeRequest
     */
    private $model;
    /**
     * Property: userService
     *
     * @var UserService
     */
    private $userService;

    public function __construct(PasswordChangeRequest $model, UserService $userService)
    {
        parent::__construct();
        $this->model = $model;
        $this->userService = $userService;
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
        if($form->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $form->errors()
            );
        }
        $findUser = $this->userService->findByEmail($form->email);
        if($findUser){

            $this->model->create([
                'user_id' => $findUser->id,
                'email' => $form->email
            ]);

            return ResponseHelper::responseData(
                Config::get('constants.PASSWORD_CHANGE_REQUEST'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                null
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_EMAIL'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
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
}
