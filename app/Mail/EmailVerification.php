<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class EmailVerification - Send email to user for verification
 *
 * @package App\Mail
 * @author Pisyek K
 * @url www.pisyek.com
 * @copyright © 2017 Pisyek Studios
 */
class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * EmailVerification constructor.
     *
     * @param User $user
     * @param $token
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user-verification')
                    ->from(config('mail.from'))
                    ->subject(config('app.name') . ' - Activate Your Account Now');
    }
}
