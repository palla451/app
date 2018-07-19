<?php

namespace App\Rules;

use App\Enumerations\UserStatus;
use App\User;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class IsActive - to check user status
 *
 * @package App\Rules
 * @author Pisyek K
 * @url www.pisyek.com
 * @copyright © 2017 Pisyek Studios
 */
class IsActive implements Rule
{
    /**
     * IsActive constructor.
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where($attribute, $value)->first();

        // Just passed this validation if no user
        if (empty($user)) {
            return true;
        }

        return $user->status === UserStatus::ACTIVE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Please verify your email first.');
    }
}
