<?php

namespace App\Enumerations;

/**
 * Class BookingStatus
 */
abstract class BookingStatus extends BasicEnum
{
    const CONFIRMED = 0;
    const OPTION = 1;
    const CANCELLED = 2;
}