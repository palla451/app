<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChangePassword - validate update password input
 *
 * @package App\Http\Requests
 * @author Pisyek K
 * @url www.pisyek.com
 * @copyright © 2017 Pisyek Studios
 */
class ChangePassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->id === (int) $this->input('id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_password' => 'required|between:6,15|confirmed'
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
