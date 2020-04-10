<?php


namespace App\Services;
use App\Feedback;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class FeedbackService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 11, 2020
 * @project   reloop
 */
class FeedbackService extends BaseService
{
    /**
     * Property: model
     *
     * @var Feedback
     */
    private $model;

    public function __construct(Feedback $model)
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
     * Method: create
     *
     * @param IForm $feedbackForm
     *
     * @return array
     */
    public function create(IForm $feedbackForm)
    {
        if($feedbackForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $feedbackForm->errors()
            );
        }
        $orderableType = '';
        if ($feedbackForm->order_type == IOrderType::COLLECTION_REQUEST){

            $findRequest = App::make(RequestService::class)->findById($feedbackForm->order_id);
            if($findRequest){

                $orderableType = $findRequest->getMorphClass();
            } else {

                return ResponseHelper::responseData(
                    Config::get('constants.INVALID_REQUEST_ID'),
                    IResponseHelperInterface::FAIL_RESPONSE,
                    false,
                    null
                );
            }

        } elseif ($feedbackForm->order_type == IOrderType::DELIEVERY_ORDER){

            $findOrder = App::make(OrderService::class)->findById($feedbackForm->order_id);
            if($findOrder){

                $orderableType = $findOrder->getMorphClass();
            } else {

                return ResponseHelper::responseData(
                    Config::get('constants.INVALID_ORDER_ID'),
                    IResponseHelperInterface::FAIL_RESPONSE,
                    false,
                    null
                );
            }
        }

        foreach ($feedbackForm->feedback as $feedback){

            $findQuestion = App::make(QuestionService::class)->findById($feedback['question_id']);
            if($findQuestion){

                $data[] = [
                    'orderable_id' => $feedbackForm->order_id,
                    'orderable_type' => $orderableType,
                    'question' => $findQuestion->question,
                    'answer' => $feedback['answer'],
                    'additional_comments' => $feedbackForm->additional_comments,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ];
            }
        }
        $this->model->insert($data);

        return ResponseHelper::responseData(
            Config::get('constants.RECORD_FEEDBACK'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            null
        );
    }
}
