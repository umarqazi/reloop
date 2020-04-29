<?php

namespace App\Repositories\Admin;

use App\Helpers\ResponseHelper;
use App\RequestCollection;
use Carbon\Carbon;

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
        $this->getModel(RequestCollection::class);
    }

    /**
     * @param $date
     * @return mixed
     *
     * @throws \Exception
     */
    public function daily($date)
    {
        return $this->model->whereHas('requests', function ($query) use ($date) {
            return $query->where('confirm', TRUE)
                    ->whereIn('created_at', $this->date('day', $date));
        });
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
            case 'day':
                for ($i = 0; $i < 7; $i ++)
                {
                    $collection[] = (new Carbon())->createFromDate(
                        $date->format('Y'),
                        $date->format('m'),
                        $date->format('d')
                    )->addDays(- $i)->format('Y-m-d');
                }
                break;

            case 'week':
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