<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserActivation
 */
class UserActivation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_activations';

    /**
     * The attributes for mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
