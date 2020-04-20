<?php


namespace App\Services;


interface IDriverTripStatus
{

    const TRIP_INITIATED  = 1;
    const RECORD_WEIGHT   = 2;
    const RECORD_FEEDBACK = 3;
    const TRIP_COMPLETED  = 4;

}
