<?php

namespace App\Http\Requests;

use App\Rules\NotSuperAdmin;
use App\Rules\Ucwords;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * To validate data before saving new users
 */
class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->canCreateUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'bail',
                'required',
                new Ucwords()
            ],
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|confirmed',
            'role' => [
                'required',
                new NotSuperAdmin()
            ]
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        $message = __('You have no authorization to perform this action.');
        throw new AuthorizationException($message);
    }
}
