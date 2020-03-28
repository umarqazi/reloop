<?php


namespace App\Services;

/**
 * Interface ISubscriptionSubType
 */
interface ISubscriptionSubType
{
    const SAME_DAY  = 1;
    const NEXT_DAY = 2;
    const SINGLE_COLLECTION = 3;
    const BULKY_ITEM = 4;
    const NORMAL = 5;
}
