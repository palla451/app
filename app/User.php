<?php

namespace App;

use App\Enumerations\UserStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * Class User
 */
class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    const CREATED_AT_DATE_FORMAT = 'j M Y, H:i';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'ragione_sociale'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * To validate scenario like admin editing superadmin
     *
     * @param integer $userId Edited user id
     * @return bool
     */
    public function checkAbilityToUpdateSelectedUser($userId)
    {
        if ($this->canUpdateUser()) {
            $editedUser = User::findOrFail($userId);
            if (!$this->hasRole('superadmin') && $editedUser->hasRole('superadmin')) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Scope to get only active user
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', '=', UserStatus::ACTIVE);
    }
}
