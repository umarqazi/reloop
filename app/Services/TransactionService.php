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
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function create($data)
    {
        $model = $this->model;
        $model->user_id = $data['user_id'];
        $model->transactionable_id = $data['product_details']->id;
        $model->transactionable_type = $data['product_details']->getMorphClass();
        $model->price = $data['product_details']->price;
        $model->save();
    }
}
