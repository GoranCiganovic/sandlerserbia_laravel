<?php

namespace App\Console\Commands;

use App\ExchangeRate;
use App\Rate;
use App\Sandler;
use App\User;
use Illuminate\Console\Command;
use Mail;

class SandlerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sandler:cron';

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
    public function __construct(Sandler $sandler, User $user, ExchangeRate $exchange, Rate $rate)
    {
        parent::__construct();

        $this->sandler = $sandler;
        $this->user = $user;
        $this->exchange = $exchange;
        $this->rate = $rate;
    }

    /**
     * On Sandler Debt Payday Insert Exchange Dollar,  Sandler %, Sandler USD, Taxes %, Taxes RSD, Change Status Paid, If Paid Date Expired Send Notification Email
     *
     * @return mixed
     */
    public function handle()
    {

        try {
            /* Number Of Unpaid Disc/Devine Tests With Paid Date On Today */
            $sandler = $this->sandler->count_unpaid_sandler_payday_today();

            if ($sandler > 0) {
                $middle_ex_dollar = $this->exchange->get_current_exchange_dollar();
                $sandler_percent = $this->rate->get_sandler_percent();
                $ppo = $rate = $this->rate->get_ppo_percent();

                /* Update Unpaid Sandler Debts With Paid Date On Today */
                $update = $this->sandler->update_unpaid_sandler_payday_today($middle_ex_dollar, $ppo, $sandler_percent);

                if (!$update) {
                    $admin_email = $this->user->get_admin_email();
                    $data = ['error' => 'Greška kod unosa Sandler dugovanja!'];
                    /* Sending Email With Error Message Sandler Update To Admin And SuperAdmin  */
                    Mail::send('sandlers.emails.debt_error', $data, function ($message) use ($admin_email) {
                        $message->from(config('mail.username'), config('constants.application_name'));
                        $message->to($admin_email);
                        $message->bcc(config('constants.superadmin_email'));
                        $message->subject('Sandler Problem');
                    });
                }
            }

            /* Count Unpaid Sandler Invoices With Paid Date Before Today */
            $non_calc_sandler = $this->sandler->count_sandler_debt_deadline_expired();

            if ($non_calc_sandler > 0) {
                $admin_email = $this->user->get_admin_email();
                $data = [
                    'msg' => 'Potrebno je uneti srednji kurs dolara kod unosa Sandler dugovanja!',
                    'url' => url('/sandler/debt'),
                ];
                /* Sending Email With Message About Inserting Sandler Debt Exchange Rate */
                Mail::send('emails.debt', $data, function ($message) use ($admin_email) {
                    $message->from(config('mail.username'), config('constants.application_name'));
                    $message->to($admin_email);
                    $message->subject('Sandler Dug');
                });
            }

            $this->info('Sandler:Cron Cummand Run successfully!');
        } catch (Exception $e) {
            Log::info('Sandler:Cron Failed!');
        }
    }
}
