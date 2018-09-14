<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\B2c\Repositories\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\B2c\Repositories\Models\Verificationhash;

/**
 * The SendVerificationMail class build the html format for the mail.
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class SendVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var App\B2c\Repositories\Models\User $User
     */
    public $User;
    
    /**
     * @var string
     */
    public $hash;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $User, string $hash)
    {
        $this->User = $User;
        $this->hash = $hash;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verification_email')->with([Verificationhash::HASH=>$this->hash]);
    }
}
