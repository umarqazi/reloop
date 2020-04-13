<?php

namespace App\Http\Controllers\Api;
use App\Forms\Collection\FeedbackForm;
use App\Forms\Collection\RecordWeightForm;
use App\Forms\Collection\TripStatusForm;
use App\Forms\User\PasswordChangeRequestForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\FeedbackService;
use App\Services\IOrderType;
use App\Services\OrderService;
use App\Services\PasswordChangeRequestService;
use App\Services\QuestionService;
use App\Services\RequestCollectionService;
use App\Services\RequestService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class DriverController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 08, 2020
 * @project   reloop
 */
class DriverController extends Controller
{
    /**
     * Property: userService
     *
     * @var UserService
     */
    private $userService;
    /**
     * Property: requestCollectionService
     *
     * @var RequestCollectionService
     */
    private $requestCollectionService;
    /**
     * Property: requestService
     *
     * @var RequestService
     */
    private $requestService;
    /**
     * Property: orderService
     *
     * @var OrderService
     */
    private $orderService;

    /**
     * DriverController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService, OrderService $orderService,
                                RequestService $requestService,
                                RequestCollectionService $requestCollectionService
    )
    {
        $this->userService = $userService;
        $this->requestCollectionService = $requestCollectionService;
        $this->requestService = $requestService;
        $this->orderService = $orderService;
    }

    /**
     * Method: driverAssignedTrips
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function driverAssignedTrips()
    {
        $driverAssignedTrips = $this->userService->driverAssignedTrips();

        return ResponseHelper::jsonResponse(
            $driverAssignedTrips['message'],
            $driverAssignedTrips['code'],
            $driverAssignedTrips['status'],
            $driverAssignedTrips['data']
        );
    }

    /**
     * Method: tripInitiated
     *
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tripStatusUpdate(Request $request)
    {
        $tripStatusForm = new TripStatusForm();
        $tripStatusForm->loadFromArray($request->all());

        if($tripStatusForm->fails()){

            return ResponseHelper::jsonResponse(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $tripStatusForm->errors()
            );
        }

        if($tripStatusForm->order_type == IOrderType::COLLECTION_REQUEST){

            $tripStatusUpdate = $this->requestService->updateRequestStatus($tripStatusForm->order_id, $tripStatusForm->status_type);
        } elseif($tripStatusForm->order_type == IOrderType::DELIEVERY_ORDER) {

            $tripStatusUpdate = $this->orderService->updateOrderStatus($tripStatusForm->order_id, $tripStatusForm->status_type);
        }

        return ResponseHelper::jsonResponse(
            $tripStatusUpdate['message'],
            $tripStatusUpdate['code'],
            $tripStatusUpdate['status'],
            $tripStatusUpdate['data']
        );
    }

    /**
     * Method: recordWeight
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordWeight(Request $request)
    {
        $recordWeightForm = new RecordWeightForm();
        $recordWeightForm->loadFromArray($request->all());

        $recordWeight = $this->requestCollectionService->recordWeight($recordWeightForm);

        return ResponseHelper::jsonResponse(
            $recordWeight['message'],
            $recordWeight['code'],
            $recordWeight['status'],
            $recordWeight['data']
        );
    }

    /**
     * Method: feedbackQuestions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function feedbackQuestions()
    {
        $feedbackQuestions = App::make(QuestionService::class)->getAll();

        return ResponseHelper::jsonResponse(
            Config::get('constants.FEEDBACK_QUESTIONS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $feedbackQuestions
        );
    }

    /**
     * Method: feedback
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function feedback(Request $request)
    {
        $feedbackForm = new FeedbackForm();
        $feedbackForm->loadFromArray($request->all());
        $feedbackService = App::make(FeedbackService::class)->create($feedbackForm);

        return ResponseHelper::jsonResponse(
            $feedbackService['message'],
            $feedbackService['code'],
            $feedbackService['status'],
            $feedbackService['data']
        );
    }

    /**
     * Method: passwordChangeRequest
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordChangeRequest(Request $request)
    {
        $passwordChangeRequestForm = new PasswordChangeRequestForm();
        $passwordChangeRequestForm->loadFromArray($request->all());
        $passwordChangeRequest = App::make(PasswordChangeRequestService::class)->store($passwordChangeRequestForm);

        return ResponseHelper::jsonResponse(
            $passwordChangeRequest['message'],
            $passwordChangeRequest['code'],
            $passwordChangeRequest['status'],
            $passwordChangeRequest['data']
        );
    }
}
