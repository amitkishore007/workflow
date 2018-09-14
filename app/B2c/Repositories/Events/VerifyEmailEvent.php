<?php

namespace App\B2c\Repositories\Events;

use App\Events\Event;
use App\B2c\Repositories\Models\User;

/**
 * The VerifyEmailEvent Class allow its listener to send verification mail when this event is triggered.
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class VerifyEmailEvent extends Event
{
    /**
     * @var string
     */
    public $hash;

    /**
     * @var App\B2c\Repositories\Models\User $User
     */
    public $User;
    
    /**
     * Create a new event instance.
     * @param App\B2c\Repositories\Models $user
     * @param string $hash
     */
    public function __construct(User $User, string $hash)
    {
        $this->User = $User;
        $this->hash = $hash;
    }
}
