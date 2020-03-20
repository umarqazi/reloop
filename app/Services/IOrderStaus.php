<?php


namespace App\Services;


interface IOrderStaus
{
    const NOT_ASSIGNED     = 1;
    const ASSIGNED         = 2;
    const TRIP_INITIATED   = 3;
    const COMPLETED        = 4;
}
