<?php


namespace App\Repositories\Admin;


use App\Page;
use App\Repositories\Admin\BaseRepo;

class PageRepo extends BaseRepo
{
    /**
     * PageRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Page::class);
    }

}
