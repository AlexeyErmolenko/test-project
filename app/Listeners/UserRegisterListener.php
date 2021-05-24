<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use App\Notifications\RegisterNewUserNotification;

/**
 * User registration listener.
 */
class UserRegisterListener
{
    /**
     * Handle the event.
     *
     * @param  UserRegisterEvent  $event
     *
     * @return void
     */
    public function handle(UserRegisterEvent $event): void
    {
        $event->getUser()->notify(new RegisterNewUserNotification());
    }
}
