<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\User;
use Mail;

class SendNotificationEmailToAdmin
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
     * Sends Notification Email To Admin When New User Is Registered
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        //\Log::info('user_created', ['user' => $event->user]);
        $data = $event->user->toArray();
        $admin_email = User::where('id', 1)->where('is_admin', 1)->value('email');

        Mail::send('auth.emails.user_created', $data, function ($message) use ($admin_email) {
            $message->from(config('mail.username'), config('constants.application_name'));
            $message->to($admin_email);
            $message->subject('Obaveštenje');
        });
    }
}
