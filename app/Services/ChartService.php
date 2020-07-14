<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        // Set up week start and end
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
    }

    /**
     * Process Bar Chart
     *
     * @param  Request  $request
     *
     * @return array
     * @throws Exception
     */
    public function barChart(Request $request): array
    {
        if($request->has('filter'))
        {
            if(method_exists($this, $request->get('filter')))
            {
                $date = $request->get('date') ? ResponseHelper::carbon($request->get('date')) : now();

                if(auth()->user()->user_type == IUserType::SUPERVISOR){

                    $supervisorId['users']['supervisorId'] = auth()->id();
                    $request->merge($supervisorId);
                    $users = $request->get('users') ?? [];
                } else {

                    $users = $request->get('users') ?? [];
                }

                return $this->{$request->get('filter')}(
                    $date, $users,
                    $request->get('filter_option'),
                    $request->get('address_id')
                );
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
     * @param Carbon $date
     * @param array $users
     * @param int $filterOption
     * @param int|null $addressId
     *
     * @return array
     * @throws Exception
     */
    public function daily(Carbon $date, array $users, int $filterOption = null, int $addressId = null): array
    {
        $startDate = ResponseHelper::carbon($date)->startOfWeek(Carbon::SUNDAY);
        $endDate = ResponseHelper::carbon($date)->endOfWeek(Carbon::SATURDAY);
        $data['header']['start'] = $startDate->format('Y-m-d');
        $data['header']['end'] = $endDate->format('Y-m-d');
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subWeek()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($startDate)->addWeek()->format('Y-m-d');

        // Set nav button and heading.
        $data['header']['text'] = $startDate->format('M d').' - '.$endDate->format('M d') .', '. $date->format('Y');

        // Get weights sum against given dates.
        $weightByWeek = $this->requestCollectionService->getWeightSum(
            $startDate, $endDate,
            '', $users,
            $filterOption, $addressId
        );
        $weightByCat = $this->requestCollectionService->getWeightSumByCat(
            $startDate, $endDate,
            $users, $filterOption,
            $addressId
        );

        // Set counter.
        $counter = 0;

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->format('D');
            $data['bar'][$counter]['data']  = [
                'start' => ResponseHelper::carbon($startDate)->format('Y-m-d')
            ];

            // Filter weight record of iterated date.
            $weight = $weightByWeek['weight']->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameDay(ResponseHelper::carbon($date));
            });

            // Set weight against iterated week.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addDay();
        }

        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name')->toArray();
        $data['pie']['data'] = $weightByCat->pluck('total_weight')->toArray();
        $data['stats'] = $weightByWeek['stats'];

        return $data;
    }

    /**
     * Method: weekly
     * Returns bar and pie chart data points.
     *
     * @param  Carbon  $date
     * @param  array  $users
     * @param int $filterOption
     * @param int|null $addressId
     *
     * @return array
     * @throws Exception
     */
    public function weekly(Carbon $date, array $users, int $filterOption = null, int $addressId = null): array
    {
        $startDate = ResponseHelper::carbon($date)->firstOfQuarter();
        $endDate = ResponseHelper::carbon($date)->lastOfQuarter();
        $data['header']['start'] = $startDate->format('Y-m-d');
        $data['header']['end'] = $endDate->format('Y-m-d');
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subWeek()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($endDate)->addWeek()->format('Y-m-d');

        switch ($startDate->quarter) {
            case 1:
                $stWk = 1;
                $endWk = 13;
                break;
            case 2:
                $stWk = 14;
                $endWk = 26;
                break;
            case 3:
                $stWk = 27;
                $endWk = 39;
                break;
            case 4:
                $stWk = 40;
                $endWk = 52;
                break;
        }

        // Set nav button and heading.
        $data['header']['text'] = "Week $stWk - Week $endWk, Q$date->quarter, " . $date->format('Y');

        // Get weights sum against given dates.
        $weightByWeek = $this->requestCollectionService->getWeightSum(
            $startDate, $endDate,
            'week', $users,
            $filterOption, $addressId
        );
        $weightByCat = $this->requestCollectionService->getWeightSumByCat(
            $startDate, $endDate,
            $users, $filterOption,
            $addressId
        );

        // Set counter.
        $counter = 0;

        // Iterate from start date to end date.
        while ($startDate <= $endDate) {

            // Set label and data of bar chart.
            $data['bar'][$counter]['label'] = $startDate->weekOfYear;
            $data['bar'][$counter]['data']  = [
                'start' => ResponseHelper::carbon($startDate)->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'),
                'end' => ResponseHelper::carbon($startDate)->endOfWeek(Carbon::SATURDAY)->format('Y-m-d')
            ];

            // Filter weight record of iterated date.
            $weight = $weightByWeek['weight']->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->format('W') === ResponseHelper::carbon($date)->format('W');
            });

            // Set weight against iterated week.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addWeek();
        }

        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name')->toArray();
        $data['pie']['data'] = $weightByCat->pluck('total_weight')->toArray();
        $data['stats'] = $weightByWeek['stats'];

        return $data;
    }

    /**
     * Method: monthly
     * Returns bar and pie chart data points.
     *
     * @param  Carbon  $date
     * @param  array  $users
     * @param int $filterOption
     * @param int|null $addressId
     *
     * @return array
     * @throws Exception
     */
    public function monthly(Carbon $date, array $users, int $filterOption = null, int $addressId = null): array
    {
        $startDate = ResponseHelper::carbon($date)->firstOfYear();
        $endDate = ResponseHelper::carbon($date)->lastOfYear();
        $data['header']['start'] = $startDate->format('Y-m-d');
        $data['header']['end'] = $endDate->format('Y-m-d');
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subMonth()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($endDate)->addMonth()->format('Y-m-d');

        // Set nav button and heading.
        $data['header']['text'] = $startDate->format('M Y') . " - " . $endDate->format('M Y');

        // Get weights sum against given dates.
        $weightByMonth = $this->requestCollectionService->getWeightSum(
            $startDate, $endDate,
            'month', $users,
            $filterOption, $addressId
        );
        $weightByCat = $this->requestCollectionService->getWeightSumByCat(
            $startDate, $endDate,
            $users, $filterOption,
            $addressId
        );

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
            $weight = $weightByMonth['weight']->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameMonth(ResponseHelper::carbon($date));
            });

            // Set weight against iterated month.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addMonth();
        }

        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name')->toArray();
        $data['pie']['data'] = $weightByCat->pluck('total_weight')->toArray();
        $data['stats'] = $weightByMonth['stats'];

        return $data;
    }

    /**
     * Method: yearly
     * Returns bar and pie chart data points.
     *
     * @param  Carbon  $date
     * @param  array  $users
     * @param int $filterOption
     * @param int|null $addressId
     *
     * @return array
     * @throws Exception
     */
    public function yearly(Carbon $date, array $users, int $filterOption = null, int $addressId = null): array
    {
        $startDate = ResponseHelper::carbon($date)->subYears(4)->startOfYear();
        $endDate = ResponseHelper::carbon($date)->endOfYear();
        $data['header']['start'] = $startDate->format('Y-m-d');
        $data['header']['end'] = $endDate->format('Y-m-d');
        $data['header']['prev'] = ResponseHelper::carbon($startDate)->subYear()->format('Y-m-d');
        $data['header']['next'] = ResponseHelper::carbon($startDate)->addYears(9)->format('Y-m-d');

        // Set nav button and heading.
        $data['header']['text'] = 'Year ' . $startDate->format('Y') . '-' . $endDate->format('Y');

        // Get weights sum against given dates.
        $weightByYear = $this->requestCollectionService->getWeightSum(
            $startDate, $endDate,
            'year', $users,
            $filterOption, $addressId
        );
        $weightByCat = $this->requestCollectionService->getWeightSumByCat(
            $startDate, $endDate,
            $users, $filterOption,
            $addressId
        );

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
            $weight = $weightByYear['weight']->filter(static function ($weight, $date) use ($startDate) {
                return $startDate->isSameYear(ResponseHelper::carbon($date));
            });

            // Set weight against iterated year.
            $data['bar'][$counter]['y'] = $weight->isEmpty() ? 0 : $weight->first();

            // Increment statements.
            $counter++;
            $startDate->addYear();
        }

        // Pie Chart data
        $data['pie']['labels'] = $weightByCat->pluck('category_name')->toArray();
        $data['pie']['data'] = $weightByCat->pluck('total_weight')->toArray();
        $data['stats'] = $weightByYear['stats'];

        return $data;
    }

    /**
     * Method: export
     * Export chart details in csv file.
     *
     * @param $request
     *
     * @return mixed|null
     * @throws Exception
     */
    public function export(Request $request)
    {
        $data = $this->barChart($request);
        if (!empty($data)) {

            return Excel::create(
                'ChartDetails',
                static function ($excel) use ($data) {
                    $excel->sheet('ChartDetails', static function ($sheet) use ($data) {

                        $row1[] = 'Filter';
                        $row2[] = 'Weight';
                        foreach ($data['bar'] as $barData) {

                            $row1[] = $barData['label'];

                            $row2[] = $barData['y'];
                        }
                        $row = [
                            ['Bar chart Details'],
                            $row1,
                            $row2,
                            [],
                            [],
                            ['Pie chart Details'],
                            ['Category', 'Weight']
                        ];

                        $pieData = array_combine($data['pie']['labels'], $data['pie']['data']);

                        foreach ($pieData as $label => $y) {
                            $row[] = [
                                $label,
                                $y
                            ];
                        }
                        $sheet->fromArray($row);
                    });

                })->export('csv');
        }

        return null;
    }
}
