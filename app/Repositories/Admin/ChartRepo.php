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
        $date = ResponseHelper::carbon($date ?? now()->format('Y-m-d'));
        switch ($filter)
        {
            case 'daily':
                for ($i = 0; $i < 7; $i ++)
                {
                    $collection[] = (new Carbon())->createFromDate(
                        $date->format('Y'),
                        $date->format('m'),
                        $date->format('d')
                    )->addDays(- $i)->format('Y-m-d');
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
