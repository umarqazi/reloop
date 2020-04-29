<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\Admin\ChartRepo;

/**
 * Class ChartService
 *
 * @package App\Services
 */
class ChartService
{

    /**
     * @var ChartRepo
     */
    private $_chartRepo;

    /**
     * ChartService constructor.
     */
    public function __construct()
    {
        $this->_chartRepo = new ChartRepo();
    }

    /**
     * Process Bar Chart
     *
     * @param Request $request
     *
     * @return array
     */
    public function barChart(Request $request)
    {
        if($request->has('filter'))
        {
            if(method_exists($this, $request->get('filter')))
            {
                return $this->{$request->get('filter')}($request->get('data'));
            }

            return [];
        }

        return [];
    }

    public function pieChart(Request $request)
    {

    }

    public function daily($date = null)
    {
        // daily logic
    }

    public function weekly($date = null)
    {
        // week login
    }

    public function monthly()
    {
        // month logic
    }

    public function yearly()
    {
        // year logic
    }
}