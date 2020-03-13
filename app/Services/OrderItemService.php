<?php


namespace App\Services;
use App\Forms\IForm;
use App\OrderItem;
use Illuminate\Validation\ValidationException;

/**
 * Class OrderItemService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class OrderItemService extends BaseService
{

    /**
     * Property: orderItem
     *
     * @var OrderItem
     */
    private $orderItem;

    public function __construct(OrderItem $orderItem)
    {
        parent::__construct();
        $this->orderItem = $orderItem;
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
     * Method: insert
     *
     * @param $data
     * @param $orderService
     *
     * @return void
     */
    public function insert($data, $orderService)
    {
        $count = 0;
        foreach ($data['product_details'] as $product){

            $orderItems[] = [
                'user_id'    => $data['user_id'],
                'order_id'   => $orderService->id,
                'product_id' => $product->id,
                'price'      => $product->price,
                'quantity'   => (int)$data['request_data']['products'][$count]['qty']
            ];
            $count++;
        }
        $this->orderItem->insert($orderItems);
    }
}
