<?php


namespace App\Services;


interface IOrderStaus
{
    const ORDER_CONFIRMED     = 1;
    const DRIVER_ASSIGNED     = 2;
    const DRIVER_DISPATCHED   = 3;
    const ORDER_COMPLETED     = 4;
    const ORDER_CANCELLED     = 5;
}
