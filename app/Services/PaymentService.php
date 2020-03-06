<?php


namespace App\Services;

use App\Forms\IForm;
use Illuminate\Support\Facades\App;

/**
 * Class PaymentService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class PaymentService extends BaseService
{
    /**
     * PaymentService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }



    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {

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
     * Method: afterCheckout
     *
     *
     * @param $makePayment
     *
     * @return void
     */
    public function afterCheckout($data)
    {
        $transaction = App::make(TransactionService::class)->create($data);
        $userSubscriptionService = App::make(UserSubscriptionService::class)->create($data);
        $orderService = App::make(OrderService::class)->create($data);
    }
}
