<?php

namespace App\Rules;

use App\Enumerations\DateFormat;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Duration implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Check for valid duration i.e. end date must be later than start date
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $time = explode(' - ', $value);
        if (!isset($time[0]) || !isset($time[1])) {
            return false;
        }

        $start = Carbon::createFromFormat(DateFormat::DATE_RANGE_PICKER, $time[0]);
        $end = Carbon::createFromFormat(DateFormat::DATE_RANGE_PICKER, $time[1]);

        return $start->lt($end);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The selected date and time is invalid');
    }
}
