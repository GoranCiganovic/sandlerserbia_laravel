<?php

namespace App\Http\Controllers;

use App\Classes\Parse;
use App\Client;
use App\Contract;
use App\DiscDevine;
use App\ExchangeRate;
use App\Invoice;
use App\Payment;
use App\Proinvoice;
use App\Sandler;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new Home Controller instance.
     *
     * @return void
     */
    public function __construct(Parse $parse, ExchangeRate $exchange, Client $client, Contract $contract, Payment $payment, Invoice $invoice, Proinvoice $proinvoice, Sandler $sandler, DiscDevine $disc_devine)
    {
        $this->parse = $parse;
        $this->exchange = $exchange;
        $this->client = $client;
        $this->contract = $contract;
        $this->payment = $payment;
        $this->invoice = $invoice;
        $this->proinvoice = $proinvoice;
        $this->sandler = $sandler;
        $this->disc_devine = $disc_devine;

        $this->middleware(['auth', 'allow'], ['except' => ['nojs']]);
    }

    /**
     * Show Home Page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Exchange Rates */
        $euro = $this->exchange->get_current_exchange_euro();
        $dollar = $this->exchange->get_current_exchange_dollar();
        /* Clients */
        $accept = $this->client->count_accept_meeting_clients();
        $jpb = $this->client->count_jpb_clients();
        /* Contracts */
        $unsigned = $this->contract->count_unsigned_contracts();
        /* Proinvoices */
        $proinvoice_issue_today = $this->payment->count_payments_advance_issue_today();
        $proinvoice_confirm_issued = $this->proinvoice->count_proinvoices_not_issued_not_paid();
        $proinvoice_confirm_paid = $this->proinvoice->count_proinvoices_issued_not_paid();
        /* Invoices */
        $invoices_from_paid_proinvoices = $this->invoice->count_invoices_from_paid_proinvoices();
        $invoices_issue_today = $this->payment->count_payments_non_advance_issue_today();
        $invoice_confirm_issued = $this->invoice->count_invoices_not_issued_not_paid();
        $invoice_confirm_paid = $this->invoice->count_invoices_issued_not_paid();
        /* Count Sandler Invoices Expired Paid Date */
        $sandler_debt = $this->sandler->count_sandler_debt_deadline_expired();
        /* Count DISC/Devine Tests Expired Paid Date */
        $disc_devine_debt = $this->disc_devine->count_disc_devine_debt_deadline_expired();

        return view('home', compact('payments_advance_issue_tomorrow', 'payments_issue_tomorrow', 'euro', 'dollar', 'accept', 'jpb', 'unsigned', 'proinvoice_issue_today', 'proinvoice_confirm_issued', 'proinvoice_confirm_paid', 'invoices_from_paid_proinvoices', 'invoices_issue_today', 'invoice_confirm_issued', 'invoice_confirm_paid', 'sandler_debt', 'disc_devine_debt'));
    }

    /**
     * Show the form for getting Statistics - Conversation Ratio, Closing Ratio, Sandler Traffic, Disc/Devine Traffic, Total Traffic - Ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function statistics(Request $request)
    {
        $method = $request->input('method');

        $this->validate($request, ['method' => "required|valid_method"]);

        $data = $this->parse->getStatisticsParams($method);
        $title = $data['title'];
        $fa_icon = $data['fa_icon'];
        $submit = $data['submit'];

        if ($request->ajax()) {
            return view('statistics.statistics_ajax', compact('title', 'fa_icon', 'submit'));
        } else {
            return back();
        }
    }

    /**
     * Display Debts - PDV(Paid Inovices Last Month), DISC/Devine (Done DD Last Month), Sandler(Paid Invoices Last Month) - Ajax.
     *
     * @return \Illuminate\Http\Response
     */
    public function debts()
    {
        /* Previous Month Name */
        $previous_month = $this->parse->get_previous_month_name();
        /* First And Last Day Of The Previous Month  */
        $from_to_days = $this->parse->get_first_and_last_day_previous_month();
        /* Count Invoices Paid Last Month */
        $pdv = $this->invoice->count_last_month_pdv_debt($from_to_days['from'], $from_to_days['to']);
        /* Count DISC/Devine Done Tests Last Month */
        $disc_devine = $this->disc_devine->count_last_month_disc_devine_debt($from_to_days['from'], $from_to_days['to']);
        /* Count DISC/Devine Tests Expired Paid Date */
        $non_calc_dd = $this->disc_devine->count_disc_devine_debt_deadline_expired();
        /* Count Sandler Invoices Issued Last Month */
        $sandler = $this->sandler->count_last_month_sandler_debt($from_to_days['from'], $from_to_days['to']);
        /* Count Sandler Debts Expired Paid Date */
        $non_calc_sandler = $this->sandler->count_sandler_debt_deadline_expired();

        return view('statistics.debts_ajax', compact('previous_month', 'pdv', 'disc_devine', 'non_calc_dd', 'sandler', 'non_calc_sandler'));
    }

    /**
     * Display No Javascript Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function nojs()
    {
        $user = Auth::check(); //Authenticated User
        $data = $this->parse->getNoJSMessage($user);
        return view('nojs.nojs', compact('data'));
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
