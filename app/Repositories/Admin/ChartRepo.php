<?php

namespace App\Repositories\Admin;

use App\Helpers\ResponseHelper;
use App\Request;
use App\RequestCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class ChartRepo
 * @package App\Repositories\Admin
 */
class ChartRepo extends BaseRepo
{

    /**
     * ChartRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Request::class);
    }

    /**
     * @param $date
     * @return mixed
     *
     * @throws \Exception
     */
    public function daily($date)
    {
        return  $this->model->with('requestCollection')
            ->whereIn('collection_date', $this->date('daily', $date))
            ->where('confirm', true);
    }

    /**
     * Method: getByDate
     * Fetch requests between given date.
     *
     * @param $strDate
     * @param $endDate
     *
     * @return mixed
     */
    public function getByDate($strDate, $endDate)
    {
        return  $this->model->with('requestCollection')
            ->whereBetween('collection_date', [$strDate, $endDate])
            ->where('confirm', true)
            ->get();
    }

    /**
     * @param $date
     * @return mixed
     * @throws \Exception
     */
    public function getByWeek($date)
    {
        return $this->model->where('confirm', TRUE)
            ->whereIn('created_at', $this->date('week', $date))
            ->with('requestCollection');
    }

    /**
     * @param $filter
     * @param $date
     * @return array
     * @throws \Exception
     */
    public function date($filter, $date)
    {
        $collection = [];
        $date = $date ?? now()->format('Y-m-d');

        switch ($filter)
        {
            case 'daily':
                for ($i = 6; $i >= 0; $i--)
                {
                    $collection[] = ResponseHelper::carbon($date)->subDays($i)->format('Y-m-d');
                }
                break;

            case 'weekly':
                for ($i = 0; $i < 14; $i ++)
                {

                }

                break;

            case 'month':
                for ($i = 0; $i < 13; $i ++)
                {

                }
                break;

            case 'year':
                for ($i = 0; $i < 6; $i ++)
                {

                }
                break;
        }


        return $collection;
    }
}
