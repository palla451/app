<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    protected $fillable = [
        'nome',
        'prezzo_per_unita',
        'column_name'
    ];
}
