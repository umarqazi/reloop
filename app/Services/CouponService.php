<?php


namespace App\Services;
use App\Coupon;
use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

/**
 * Class CouponService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 12, 2020
 * @project   reloop
 */
class CouponService extends BaseService
{

    /**
     * Property: model
     *
     * @var Coupon
     */
    private $model;

    public function __construct(Coupon $model)
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
}
