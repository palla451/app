<?php

namespace App;

use App\Enumerations\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    const DATE_FORMAT = 'j M Y, H:i';

    protected $dates = [
        'start_date',
        'end_date',
        'deleted_at'
    ];

    protected $fillable = [
        'booked_by',
        'booked_name',
        'room_id',
        'start_date',
        'end_date',
        'status',
        'location',
        'location_id',
        'price',
        'optional_id',
        'room_setup'
    ];

    /**
     * Get room details which related to this booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get user who related to this booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

    /**
     * Get duration for current booking
     *
     * @return mixed
     */
    public function getDuration()
    {
        $year = '';
        $month = '';
        $day = '';
        $hour = '';
        $minute = '';

        if (isset($this->start_date) && isset($this->end_date)) {
            $duration = $this->end_date->diff($this->start_date);

            $tempArray = [];

            if (!empty($duration->y)) {
                $tempArray[] = $duration->y . ($duration->y > 1 ? ' years' : ' year');
            }

            if (!empty($duration->m)) {
                $tempArray[] = $duration->m . ($duration->m > 1 ? ' months' : ' month');
            }

            if (!empty($duration->d)) {
                $tempArray[] = $duration->d . ($duration->d > 1 ? ' days' : ' day');
            }

            if (!empty($duration->h)) {
                $tempArray[] = $duration->h . ($duration->h > 1 ? ' hours' : ' hour');
            }

            if (!empty($duration->i)) {
                $tempArray[] = $duration->i . ($duration->i > 1 ? ' minutes' : ' minute');
            }

            $last = array_pop($tempArray);
            return count($tempArray) ? implode(', ', $tempArray) . ' &amp; ' . $last : $last;
        }
    }

    /**
     * Get Status in text
     *
     * @return string
     */
    public function getStatusTextualRepresentation()
    {
        $text = '';
        switch ($this->status) {
            case BookingStatus::CONFIRMED:
                $text = 'Confirmed';
                break;
            case BookingStatus::OPTION:
                $text = 'Option';
                break;
            case BookingStatus::CANCELLED:
                $text = 'Cancelled';
                break;
            default:
                break;
        }

        return $text;
    }
}
