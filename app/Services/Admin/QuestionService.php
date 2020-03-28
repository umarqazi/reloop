<?php


namespace App\Services\Admin;


use App\Repositories\Admin\QuestionRepo;
use App\Services\Admin\BaseService;


class QuestionService extends BaseService
{

    private $questionRepo;

    /**
     * QuestionService constructor.
     */

    public function __construct()
    {
        $questionRepo =  $this->getRepo(QuestionRepo::class);
        $this->questionRepo = new $questionRepo;
    }


}
