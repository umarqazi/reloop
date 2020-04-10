<?php


namespace App\Services;
use App\Forms\IForm;
use App\Question;
use Illuminate\Validation\ValidationException;

/**
 * Class QuestionService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 10, 2020
 * @project   reloop
 */
class QuestionService extends BaseService
{

    /**
     * Property: model
     *
     * @var Question
     */
    private $model;

    public function __construct(Question $model)
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

    public function getAll()
    {
        return $this->model->all();
    }
}
