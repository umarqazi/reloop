<?php


namespace App\Services;


use App\Forms\IForm;
use App\Transaction;
use Illuminate\Validation\ValidationException;

/**
 * Class TransactionService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class TransactionService extends BaseService
{
    private $model;

    public function __construct(Transaction $model)
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
     * Method: getAll
     *
     * @return Transaction[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function buyPlanTransaction($data, $transactionable)
    {
        $model = $this->model;
        $model->user_id = $data['user_id'];
        $model->transactionable_id = $transactionable->id;
        $model->transactionable_type = $transactionable->getMorphClass();

        if (array_key_exists('plan', $data['stripe_response'])) {
            $processedData = $data['stripe_response']['plan'];
        } else {
            $processedData = $data['stripe_response'];
        }
        $model->total = $processedData['amount']/100;
        $model->save();
    }

    public function buyProductTransaction($data, $transactionable)
    {
        $model = $this->model;
        $model->user_id = $data['user_id'];
        $model->transactionable_id = $transactionable->id;
        $model->transactionable_type = $transactionable->getMorphClass();
        $model->total = $data['stripe_response']['amount']/100;
        $model->save();
    }

    /**
     * Method: extraCharge
     *
     * @param $data
     *
     * @return void
     */
    public function extraCharge($data)
    {
        $model = $this->model;
        $model->user_id = $data['user_id'];
        $model->total = $data['extra_charge'];
        $model->save();
    }

    /**
     * Method: userBillings
     *
     * @param $userId
     *
     * @return mixed
     */
    public function userBillings($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * Method: renewPlanTransaction
     *
     * @param $transactionable
     *
     * @return void
     */
    public function renewPlanTransaction($transactionable)
    {
        $model = $this->model;
        $model->user_id = $transactionable->user_id;
        $model->transactionable_id = $transactionable->id;
        $model->transactionable_type = $transactionable->getMorphClass();
        $model->total = $transactionable->total;
        $model->save();
    }
}
