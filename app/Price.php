<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    protected $primaryKey = 'id_price';

    protected $fillable = [
        'price_id',
        'room_id',
        'price',
        'duration'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
