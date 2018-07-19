<?php

namespace App;

use App\Enumerations\BookingStatus;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
