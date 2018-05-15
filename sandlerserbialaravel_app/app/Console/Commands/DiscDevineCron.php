<?php

namespace App\Console\Commands;

use App\DiscDevine;
use App\ExchangeRate;
use App\Rate;
use App\User;
use Illuminate\Console\Command;
use Mail;

class DiscDevineCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discdevine:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DiscDevine $disc_devine, User $user, ExchangeRate $exchange, Rate $rate)
    {
        parent::__construct();

        $this->disc_devine = $disc_devine;
        $this->user = $user;
        $this->exchange = $exchange;
        $this->rate = $rate;
    }

    /**
     * On DISC/Devine Debt Paying Day Insert Exchange Dollar, Disc/Devine RSD, Taxes %, Taxes RSD, Change Status Paid, If Paid Date Expired Send Notification Email
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            /* Number Of Unpaid Disc/Devine Tests With Paid Date On Today */
            $disc_devine = $this->disc_devine->count_unpaid_disc_devine_payday_today();

            if ($disc_devine > 0) {
                $middle_ex_dollar = $this->exchange->get_current_exchange_dollar();
                $ppo = $rate = $this->rate->get_ppo_percent();

                /* Update Unpaid Disc/Devine Tests With Paid Date On Today */
                $update = $this->disc_devine->update_unpaid_disc_devine_payday_today($middle_ex_dollar, $ppo);
                if (!$update) {
                    $admin_email = $this->user->get_admin_email();
                    $data = ['error' => 'Greška kod unosa DISC/Devine dugovanja!'];

                    /* Sending Email With Error Message Disc/Devine Update To Admin And SuperAdmin  */
                    Mail::send('disc_devines.emails.debt_error', $data, function ($message) use ($admin_email) {
                        $message->from(config('mail.username'), config('constants.application_name'));
                        $message->to($admin_email);
                        $message->bcc(config('constants.superadmin_email'));
                        $message->subject('DISC/Devine Problem');
                    });
                }
            }

            /* Count Unpaid DISC/Devine Tests With Paid Date Before Today */
            $non_calc_dd = $this->disc_devine->count_disc_devine_debt_deadline_expired();

            if ($non_calc_dd > 0) {
                $admin_email = $this->user->get_admin_email();
                $data = [
                    'msg' => 'Potrebno je uneti srednji kurs dolara kod unosa DISC/Devine dugovanja!',
                    'url' => url('/disc_devine/debt'),
                ];

                /* Sending Email With Message About Inserting Disc/Devine Debt Exchange Rate */
                Mail::send('emails.debt', $data, function ($message) use ($admin_email) {
                    $message->from(config('mail.username'), config('constants.application_name'));
                    $message->to($admin_email);
                    $message->subject('DISC/Devine Dug');
                });
            }

            $this->info('DiscDevine:Cron Cummand Run successfully!');
        } catch (Exception $e) {
            Log::info('DiscDevine:Cron Failed!');
        }
    }
}
