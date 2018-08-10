<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\User;
use Mail;

class SendWelcomeEmailToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Sends Welcome Email To User When It Is Registered
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        //\Log::info('user_registered', ['user' => $event->user]);

        $data = $event->user->toArray();
        $user_email = $event->user->email;

        Mail::send('auth.emails.user_registered', $data, function ($message) use ($user_email) {
            $message->from(config('mail.username'), config('constants.application_name'));
            $message->to($user_email);
            $message->subject('Dobrodošli');
        });
    }
}
