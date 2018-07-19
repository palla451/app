<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Rule to check if given string is in ucwords
 */
class Ucwords implements Rule
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
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ucwords($value) === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The first character of each word in the :attribute must be uppercase');
    }
}
