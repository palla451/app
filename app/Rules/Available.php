<?php

namespace App\Rules;

use App\Booking;
use App\Enumerations\BookingStatus;
use App\Enumerations\DateFormat;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

/**
 * Rule to check if the selected room is still available for booking
 */
class Available implements Rule
{
    protected $roomId;

    /**
     * Available constructor.
     * @param $roomId
     */
    public function __construct($roomId = null)
    {
        $this->roomId = $roomId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
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

        $bookings = Booking::where([
                                ['start_date', '>=', $start],
                                ['end_date', '<=', $end],
                                ['status', '=', BookingStatus::OPTION]
                            ])
                                ->orWhere(function($query) use ($start, $end){
                                    $query->where([
                                        ['start_date', '<=', $start],
                                        ['end_date', '>=', $end],
                                        ['status', '=', BookingStatus::OPTION]
                                    ]);
                                })
                                ->orWhere(function($query) use ($start, $end){
                                    $query->where([
                                        ['start_date', '>', $start],
                                        ['start_date', '<', $end],
                                        ['end_date', '>=', $end],
                                        ['status', '=', BookingStatus::OPTION]
                                    ]);
                                })
                                ->orWhere(function($query) use ($start, $end){
                                    $query->where([
                                        ['start_date', '<=', $start],
                                        ['end_date', '>', $start],
                                        ['end_date', '<', $end],
                                        ['status', '=', BookingStatus::OPTION]
                                    ]);
                                })
                            ->distinct()
                            ->get();

        $unavailableRoomIds = $bookings->pluck('room_id');

        return !in_array($this->roomId, $unavailableRoomIds->all());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('This room is unavailable for booking during selected time');
    }
}
