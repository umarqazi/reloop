<?php

namespace App\Http\Controllers\Admin;

use App\Services\ChartService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ChartController
 *
 * @package App\Http\Controllers\Admin
 */
class ChartController extends Controller
{

    /**
     * @var ChartService
     */
    private $_chartService;

    /**
     * ChartController constructor.
     */
    public function __construct()
    {
        $this->_chartService = new ChartService();
    }

    /**
     * Draw Bar Chart
     *
     * @param Request $request
     *
     * @return array
     */
    public function barChart(Request $request)
    {
        return $this->_chartService->barChart($request);
    }

    /**
     * Draw Pie Chart
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function pieChart(Request $request)
    {
        return $this->_chartService->pieChart($request);
    }
}
