<?php


namespace App\Services;

/**
 * Interface ISubscriptionSubType
 */
interface IUserSubscriptionStatus
{
    const ACTIVE    = 1;
    const PENDING   = 2;
    const COMPLETED = 3;
    const EXPIRED   = 4;
}
