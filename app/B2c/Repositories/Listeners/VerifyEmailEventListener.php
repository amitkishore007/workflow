<?php

namespace App\B2c\Repositories\Listeners;

use App\Mail\SendVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\B2c\Repositories\Events\VerifyEmailEvent;

/**
 * The VerifyEmailEventListener Class listen to the event and send verification mail to user.
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class VerifyEmailEventListener
{
    /**
     * send verificaion mail on event.
     *
     * @param  App\B2c\Repositories\Events\VerifyEmailEvent  $Event
     */
    public function handle(VerifyEmailEvent $Event)
    {
         Mail::to($Event->User->email)->send(new SendVerificationMail($Event->User, $Event->hash));
    }
}
