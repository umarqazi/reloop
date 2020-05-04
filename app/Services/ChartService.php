<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use Carbon\Carbon;
use Exception;
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

    /**
     * Method: daily
     *
     * @param  null  $date
     *
     * @return array
     * @throws Exception
     */
    public function daily($date = null): array
    {
        $data = [];
        $dailyReports = $this->_chartRepo->daily($date)->get();
        $dates = $this->_chartRepo->date('daily', $date);

        $getWeightByWeek  = App::make(RequestCollectionService::class)->getWeightByWeek($dates);

        foreach ($dates as $index => $currentDate){

            //$data[$index]['label'] = date('D', strtotime($currentDate));
            $data['bar'][$index]['label'] = Carbon::createFromDate($currentDate)->format('d-M');
            $data['bar'][$index]['data']  = $currentDate;

            $currentY = 0;
            foreach ($dailyReports as $dailyReport){

                $collectionDate = $dailyReport->collection_date;

                if($currentDate == $collectionDate){

                    $currentY  = App::make(RequestCollectionService::class)->getWeightByDate($currentDate);
                    break;
                }
            }
            $data['bar'][$index]['y'] = $currentY;

        }

        // Pie Chart data
        $data['pie']['labels'] = $getWeightByWeek->pluck('category_name');
        $data['pie']['data'] = $getWeightByWeek->pluck('total_weight');

        return $data;
    }

    /**
     * Method: weekly
     * Returns bar and pie chart data points.
     *
     * @param  null  $date
     *
     * @return array
     * @throws Exception
     */
    public function weekly($date = null)
    {
        /* @var RequestCollectionService $requestCollectionService */
        $requestCollectionService = App::make(RequestCollectionService::class);
        $date = $date ?? now()->format('Y-m-d');

        $startDate = ResponseHelper::carbon($date)->firstOfQuarter();
        $endDate = ResponseHelper::carbon($date)->lastOfQuarter();

        // Get weight sum against given dates.
        $weightByWeek = $requestCollectionService->getWeightSum($startDate, $endDate, 'week');

        $weightByCat = $requestCollectionService->getWeightSumByCat($startDate, $endDate);

        // Starting dates from the start of week.
        $startDate->startOfWeek();
        $endDate->startOfWeek();
        $counter = 1;
        $data = [];

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->format('Y-m-d');
            $data['bar'][$counter]['data']  = "Week - $counter";

            // Filter weight record of iterated date.
            $weight = $weightByWeek->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameWeek(ResponseHelper::carbon($date));
            });

            // Set weight against iterated week.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addWeek();
        }
        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name');
        $data['pie']['data'] = $weightByCat->pluck('total_weight');

        return $data;

    }

    /**
     * Method: monthly
     * Returns bar and pie chart data points.
     *
     * @param  null  $date
     *
     * @return array
     * @throws Exception
     */
    public function monthly($date = null)
    {
        /* @var RequestCollectionService $requestCollectionService */
        $requestCollectionService = App::make(RequestCollectionService::class);
        $date = $date ?? now()->format('Y-m-d');

        $startDate = ResponseHelper::carbon($date)->firstOfQuarter();
        $endDate = ResponseHelper::carbon($date)->lastOfQuarter();

        // Get weight sum against given dates.
        $totalWeight = $requestCollectionService->getWeightSum($startDate, $endDate, 'month');

        $weightByCat = $requestCollectionService->getWeightSumByCat($startDate, $endDate);

        // Starting dates from the start of week.
        $startDate->startOfMonth();
        $endDate->startOfMonth();
        $counter = 1;
        $data = [];

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->format('Y-m-d');
            $data['bar'][$counter]['data']  = $startDate->format('M');

            // Filter weight record of iterated date.
            $weight = $totalWeight->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameWeek(ResponseHelper::carbon($date));
            });

            // Set weight against iterated week.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addMonth();
        }

        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name');
        $data['pie']['data'] = $weightByCat->pluck('total_weight');

        return $data;
    }

    /**
     * Method: yearly
     * Returns bar and pie chart data points.
     *
     * @param  null  $date
     *
     * @return array
     * @throws Exception
     */
    public function yearly($date = null)
    {
        /* @var RequestCollectionService $requestCollectionService */
        $requestCollectionService = App::make(RequestCollectionService::class);
        $date = $date ?? now()->format('Y-m-d');

        $startDate = ResponseHelper::carbon($date)->subYears(4);
        $endDate = ResponseHelper::carbon($date);

        // Get weight sum against given dates.
        $totalWeight = $requestCollectionService->getWeightSum($startDate, $endDate, 'year');

        $weightByCat = $requestCollectionService->getWeightSumByCat($startDate, $endDate);

        // Starting dates from the start of week.
        $startDate->startOfYear();
        $endDate->startOfYear();
        $counter = 1;
        $data = [];

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->format('Y-m-d');
            $data['bar'][$counter]['data']  = $startDate->format('Y');

            // Filter weight record of iterated date.
            $weight = $totalWeight->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameWeek(ResponseHelper::carbon($date));
            });

            // Set weight against iterated week.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addYear();
        }

        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name');
        $data['pie']['data'] = $weightByCat->pluck('total_weight');

        return $data;
    }
}
