<?php


namespace App\Services;


use App\Forms\IForm;
use App\UserCard;
use Illuminate\Validation\ValidationException;

/**
 * Class UserCardService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Aug 07, 2020
 * @project   reloop
 */
class UserCardService extends BaseService
{

    /**
     * Property: model
     *
     * @var UserCard
     */
    private $model;

    public function __construct(UserCard $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function store(IForm $form)
    {
        // TODO: Implement store() method.
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function saveCardDetails($data)
    {
        return $this->model->create($data);
    }

    /**
     * Method: findByUserId
     *
     * @param $userId
     *
     * @return mixed
     */
    public function findByUserId($userId)
    {
        return $this->model->where(['user_id' => $userId, 'default' => true])->first();
    }
}
