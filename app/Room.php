<?php

namespace App;

use App\Enumerations\BookingStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * Room model
 */
class Room extends Model
{

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'pax',
        'type',
        'location',
        'price_id',
        'location_id'
    ];

    /**
     * Get available room for booking
     *
     * @param $query
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function scopeAvailable($query, $start, $end)
    {
        $unavailableRooms = Booking::where([
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

        return $query->whereNotIn('id', $unavailableRooms->pluck('room_id'));
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
