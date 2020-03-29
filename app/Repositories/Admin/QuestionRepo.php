<?php


namespace App\Repositories\Admin;


use App\Question;
use App\Repositories\Admin\BaseRepo;

class QuestionRepo extends BaseRepo
{
    /**
     * QuestionRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Question::class);
    }

}
