<?php


namespace App\Services\Admin;


use App\Repositories\Admin\PageRepo;
use App\Services\Admin\BaseService;

class PageService extends BaseService
{

    private $productRepo;

    /**
     * PageService constructor.
     */

    public function __construct()
    {
        $pageRepo   =  $this->getRepo(PageRepo::class);
        $this->pageRepo = new $pageRepo;
    }

}
