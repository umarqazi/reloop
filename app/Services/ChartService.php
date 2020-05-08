<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\Admin\ChartRepo;
use Illuminate\Support\Facades\App;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class ChartService
 *
 * @package App\Services
 */
class ChartService
{
    /**
     * Property: requestCollectionService
     *
     * @var RequestCollectionService
     */
    private $requestCollectionService;

    /**
     * ChartService constructor.
     *
     * @param  RequestCollectionService  $requestCollectionService
     */
    public function __construct(RequestCollectionService $requestCollectionService)
    {
        $this->requestCollectionService = $requestCollectionService;
    }

    /**
     * Process Bar Chart
     *
     * @param  Request  $request
     *
     * @return array
     * @throws Exception
     */
    public function barChart(Request $request)
    {
        if($request->has('filter'))
        {
            if(method_exists($this, $request->get('filter')))
            {
                $date = $request->get('data') ? ResponseHelper::carbon($request->get('data')) : now();
                return $this->{$request->get('filter')}($date);
            }

            return [];
        }

        return [];
    }

    /**
     * Method: pieChart
     * Returns pie chart data points of requested date.
     *
     * @param  Request  $request
     *
     * @return array
     * @throws Exception
     */
    public function pieChart(Request $request): array
    {
        $data = [];
        $startDate = $request->start ?? null;
        $endDate = $request->end ?? $startDate;

        if ($startDate) {

            $startDate = ResponseHelper::carbon($startDate);
            $endDate = ResponseHelper::carbon($endDate);

            // Get weight w.r.t category.
            $weightByCat = $this->requestCollectionService->getWeightSumByCat($startDate, $endDate);

            // Pie Chart data
            $data['labels'] = $weightByCat->pluck('category_name');
            $data['data'] = $weightByCat->pluck('total_weight');
        }

        return $data;
    }

    /**
     * Method: daily
     * Returns the daily stats data of week.
     *
     * @param  Carbon  $date
     *
     * @return array
     * @throws Exception
     */
    public function daily(Carbon $date): array
    {
        $startDate = ResponseHelper::carbon($date)->startOfWeek(Carbon::SUNDAY);
        $endDate = ResponseHelper::carbon($date)->endOfWeek(Carbon::SATURDAY);
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subWeek()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($startDate)->addWeek()->format('Y-m-d');

        // Set nav button and heading.
        $data['header']['text'] = 'Daily Stats ' . $date->format('Y');

        // Get weights sum against given dates.
        $weightByWeek = $this->requestCollectionService->getWeightSum($startDate, $endDate);
        $weightByCat = $this->requestCollectionService->getWeightSumByCat($startDate, $endDate);

        // Set counter.
        $counter = 0;

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->format('d-M');
            $data['bar'][$counter]['data']  = [
                'start' => ResponseHelper::carbon($startDate)->format('Y-m-d')
            ];

            // Filter weight record of iterated date.
            $weight = $weightByWeek->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameDay(ResponseHelper::carbon($date));
            });

            // Set weight against iterated week.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addDay();
        }

        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name');
        $data['pie']['data'] = $weightByCat->pluck('total_weight');

        return $data;
    }

    /**
     * Method: weekly
     * Returns bar and pie chart data points.
     *
     * @param  Carbon  $date
     *
     * @return array
     * @throws Exception
     */
    public function weekly(Carbon $date): array
    {
        $startDate = ResponseHelper::carbon($date)->firstOfQuarter();
        $endDate = ResponseHelper::carbon($date)->lastOfQuarter();
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subWeek()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($endDate)->addWeek()->format('Y-m-d');

        // Set nav button and heading.
        $data['header']['text'] = 'Quarter-' . $date->quarter ." " . $date->format('Y');

        // Get weight sum against given dates.
        $weightByWeek = $this->requestCollectionService->getWeightSum($startDate, $endDate, 'week');
        $weightByCat = $this->requestCollectionService->getWeightSumByCat($startDate, $endDate);

        // Set counter.
        $counter = 0;

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $counter;
            $data['bar'][$counter]['data']  = [
                'start' => ResponseHelper::carbon($startDate)->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'),
                'end' => ResponseHelper::carbon($startDate)->endOfWeek(Carbon::SATURDAY)->format('Y-m-d')
            ];

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
     * @param  Carbon  $date
     *
     * @return array
     * @throws Exception
     */
    public function monthly(Carbon $date): array
    {
        $startDate = ResponseHelper::carbon($date)->firstOfQuarter();
        $endDate = ResponseHelper::carbon($date)->lastOfQuarter();
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subMonth()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($endDate)->addMonth()->format('Y-m-d');

        // Set nav button and heading.
        $data['header']['text'] = 'Quarter-' . $date->quarter ." " . $date->format('Y');

        // Get weight sum against given dates.
        $weightByMonth = $this->requestCollectionService->getWeightSum($startDate, $endDate, 'month');
        $weightByCat = $this->requestCollectionService->getWeightSumByCat($startDate, $endDate);

        // Set counter.
        $counter = 0;

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->format('M');
            $data['bar'][$counter]['data']  = [
                'start' => ResponseHelper::carbon($startDate)->startOfMonth()->format('Y-m-d'),
                'end' => ResponseHelper::carbon($startDate)->endOfMonth()->format('Y-m-d')
            ];

            // Filter weight record of iterated date.
            $weight = $weightByMonth->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameMonth(ResponseHelper::carbon($date));
            });

            // Set weight against iterated month.
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
     * @param  Carbon  $date
     *
     * @return array
     * @throws Exception
     */
    public function yearly(Carbon $date): array
    {
        $startDate = ResponseHelper::carbon($date)->subYears(4)->startOfYear();
        $endDate = ResponseHelper::carbon($date)->endOfYear();
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subYear()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($startDate)->addYears(9)->format('Y-m-d');

        // Set nav button and heading.
        $data['header']['text'] = 'Year ' . $startDate->format('Y') . '-' . $endDate->format('Y');

        // Get weight sum against given dates.
        $weightByYear = $this->requestCollectionService->getWeightSum($startDate, $endDate, 'year');
        $weightByCat = $this->requestCollectionService->getWeightSumByCat($startDate, $endDate);

        // Set counter.
        $counter = 0;

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->format('Y');
            $data['bar'][$counter]['data']  = [
                'start' => ResponseHelper::carbon($startDate)->startOfYear()->format('Y-m-d'),
                'end' => ResponseHelper::carbon($startDate)->endOfYear()->format('Y-m-d')
            ];

            // Filter weight record of iterated date.
            $weight = $weightByYear->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameYear(ResponseHelper::carbon($date));
            });

            // Set weight against iterated year.
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
