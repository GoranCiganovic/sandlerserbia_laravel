<?php

namespace App\Console\Commands;

use App\Classes\Parse;
use App\Client;
use App\Contract;
use App\Individual;
use App\Invoice;
use App\Legal;
use App\Payment;
use App\Proinvoice;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Mail;

class NotificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:cron';

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
    public function __construct(User $user, Client $client, Legal $legal, Individual $individual = null, Contract $contract, Payment $payment, Invoice $invoice, Proinvoice $proinvoice, Parse $parse)
    {
        parent::__construct();

        $this->user = $user;
        $this->client = $client;
        $this->legal = $legal;
        $this->individual = $individual;
        $this->contract = $contract;
        $this->payment = $payment;
        $this->invoice = $invoice;
        $this->proinvoice = $proinvoice;
        $this->parse = $parse;
    }

    /**
     * Send Notification Email for Today's Meetings, Tomorrow's Meetings, Contracts (Accept, JPB and Unsigned), Proinovices (Created, Confirm Paid, Proinvocie pay date) and Invoices (From Proinvoices, Created, Confirm Paid, Invoice pay date)
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            /* Dates - Now, Tomorrow, Day After Tomorrow */
            $now = Carbon::now();
            $tomorrow = Carbon::tomorrow();
            $day_after_tomorrow = new Carbon('tomorrow + 1day');

            /* Legals With Meeting Date Today (From Now Until Tomorrow) */
            $legals_today = $this->legal->get_legals_meeting_date_range($now, $tomorrow);
            $leg_meet_today = $this->localize_meeting_date_data($legals_today);
            /* Individuals With Meeting Date Today (From Now Until Tomorrow) */
            $individuals_today = $this->individual->get_individuals_meeting_date_range($now, $tomorrow);
            $ind_meet_today = $this->localize_meeting_date_data($individuals_today);
            /* Clients (Legals And Individuals) With Today's Meeting Date */
            $todays_meetings = array_merge($leg_meet_today->toArray(), $ind_meet_today->toArray());

            /* Legals With Meeting Date Tomorrow (From Tomorrow Until Day After Tommorow) */
            $legals_tomorrow = $this->legal->get_legals_meeting_date_range($tomorrow, $day_after_tomorrow);
            $leg_meet_tomorrow = $this->localize_meeting_date_data($legals_tomorrow);
            /* Individuals With Meeting Date Tomorrow (From Tomorrow Until Day After Tommorow) */
            $individuals_tomorrow = $this->individual->get_individuals_meeting_date_range($tomorrow, $day_after_tomorrow);
            $ind_meet_tomorrow = $this->localize_meeting_date_data($individuals_tomorrow);
            /* Clients (Legals And Individuals) With Tomorrow's Meeting Date */
            $tomorrows_meetings = array_merge($leg_meet_tomorrow->toArray(), $ind_meet_tomorrow->toArray());

            /* Payments-Advance Tomorrow Issue */
            $payments_advance_issue_tomorrow = $this->payment->get_payments_advance_issue_tomorrow();
            /* Payments Tomorrow Issue */
            $payments_non_advance_issue_tomorrow = $this->payment->get_payments_non_advance_issue_tomorrow();

            /* Suspects - Accept Meeting */
            $accept = $this->client->count_accept_meeting_clients();
            /* Suspects - Accept Meeting */
            $jpb = $this->client->count_jpb_clients();

            /* Contracts - Unsigned */
            $unsigned = $this->contract->count_unsigned_contracts();

            /* Proinvoices (Payment) Payday On Today  */
            $proinvoice_pay_date = $this->payment->count_payments_advance_issue_today();
            /* Invoices (Payment) Payday On Today  */
            $invoice_pay_date = $this->payment->count_payments_non_advance_issue_today();

            /* Created Proinvoices - Not Issued, Not Paid */
            $created_proinvoices = $this->proinvoice->count_proinvoices_not_issued_not_paid();
            /* Issued Proinvoices - Issued, Not Paid*/
            $confirm_paid_proinvoices = $this->proinvoice->count_proinvoices_issued_not_paid();

            /* Invoices From Proinvoices - Paid, Not Issued */
            $invoices_from_proinvoices = $this->invoice->count_invoices_from_paid_proinvoices();
            /* Created Invoices - Not Issued, Not Paid */
            $created_invoices = $this->invoice->count_invoices_not_issued_not_paid();
            /* Issued Invoices - Issued, Not Paid*/
            $confirm_paid_invoices = $this->invoice->count_invoices_issued_not_paid();

            $data = [
                'todays_meetings' => $todays_meetings,
                'tomorrows_meetings' => $tomorrows_meetings,
                'payments_advance_issue_tomorrow' => $payments_advance_issue_tomorrow,
                'payments_non_advance_issue_tomorrow' => $payments_non_advance_issue_tomorrow,
                'accept' => $accept,
                'jpb' => $jpb,
                'unsigned' => $unsigned,
                'proinvoice_pay_date' => $proinvoice_pay_date,
                'invoice_pay_date' => $invoice_pay_date,
                'created_proinvoices' => $created_proinvoices,
                'confirm_paid_proinvoices' => $confirm_paid_proinvoices,
                'invoices_from_proinvoices' => $invoices_from_proinvoices,
                'created_invoices' => $created_invoices,
                'confirm_paid_invoices' => $confirm_paid_invoices,
            ];

            $sum = [count($todays_meetings), count($tomorrows_meetings), count($payments_advance_issue_tomorrow), count($payments_non_advance_issue_tomorrow), $accept, $jpb, $unsigned, $proinvoice_pay_date, $invoice_pay_date, $created_proinvoices, $confirm_paid_proinvoices, $invoices_from_proinvoices, $created_invoices, $confirm_paid_invoices];

            if (array_sum($sum) > 0) {
                $admin_email = $this->user->get_admin_email();
                /* Sending Email With Notification Message */
                Mail::send('emails.notification', $data, function ($message) use ($admin_email) {
                    $message->from(config('mail.username'), config('constants.application_name'));
                    $message->to($admin_email);
                    $message->subject('Obaveštenje');
                });
            }

            $this->info('Notification:Cron Cummand Run successfully!');
        } catch (Exception $e) {
            Log::info('Notification:Cron Failed!');
        }
    }

    /**
     * Returns Clients With Replaced Day And Month Name In Serbian
     *
     * @param  array
     * @return  array
     */
    public function localize_meeting_date_data($clients)
    {
        foreach ($clients as $client) {
            $client->meeting_date = $this->parse->get_serbian_day_name($client->meeting_date);
            $client->meeting_date = $this->parse->get_serbian_month_name($client->meeting_date);
        }
        return $clients;
    }
}
