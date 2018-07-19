<?php

namespace App\Http\Requests;

use App\Rules\Available;
use App\Rules\Duration;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate request before storing booking
 */
class StoreBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->canCreateBooking();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roomId' => [
                'bail',
                'required',
                'integer'
            ],
            'bookingTime' => [
                'required',
                new Duration,
                new Available($this->input('roomId'))
            ],
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
