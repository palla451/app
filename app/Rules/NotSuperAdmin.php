<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class NotSuperAdmin
 */
class NotSuperAdmin implements Rule
{
    protected $user = null;
    protected $error = false;

    /**
     * NotSuperAdmin constructor.
     *
     * @param integer $id
     */
    public function __construct($id = null)
    {
        if (isset($id)) {
            $this->user = User::findOrFail($id);
        }
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
        if (isset($this->user)) {
            if ($this->user->hasRole('superadmin')) {
                $this->error = true;
                return (int) $value === 1;
            } else {
                return (int) $value !== 1;
            }
        } else {
            return (int) $value !== 1;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error ?
            __('Role superadmin cannot be deselected.') : __('Role superadmin cannot be selected.');
    }
}
