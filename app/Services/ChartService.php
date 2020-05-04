<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Admin\ChartRepo;
use Illuminate\Support\Facades\App;

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
        $dailyReports = $this->_chartRepo->daily($date)->get();
        $dates = $this->_chartRepo->date('daily', $date);

        $getWeightByWeek  = App::make(RequestCollectionService::class)->getWeightByWeek($dates);
        foreach ($dates as $index => $date){

            //$data[$index]['label'] = date('D', strtotime($date));
            $data[$index]['label'] = Carbon::createFromDate($date)->format('d-M');
            $data[$index]['data']  = $date;

            $currentY = 0;
            foreach ($dailyReports as $dailyReport){

                $collectionDate = $dailyReport->collection_date;

                if($date == $collectionDate){

                    $currentY  = App::make(RequestCollectionService::class)->getWeightByDate($date);
                    break;
                }
            }
            $data[$index]['y'] = $currentY;
            $data[$index]['pie'] = $getWeightByWeek;
        }
        return $data;
    }

    public function weekly($date = null)
    {
        dd('weekly');
    }

    public function monthly()
    {
        dd('monthly');
    }

    public function yearly()
    {
        dd('yearly');
    }
}
