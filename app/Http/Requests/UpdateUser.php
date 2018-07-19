<?php

namespace App\Http\Requests;

use App\Rules\NotSuperAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validate user data before updating user
 */
class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->checkAbilityToUpdateSelectedUser($this->input('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required',
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($this->input('id'), 'id')
            ],
            'password' => [
                'bail',
                'nullable',
                'between:8,15',
                'confirmed',
                'required_with:password_confirmation'
            ],
            'role' => [
                'required',
                new NotSuperAdmin($this->input('id'))
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
