<?php

namespace App\Http\Controllers;

use App\Sandler;
use App\Classes\Parse;
use App\Rate;
use App\ExchangeRate;
use Illuminate\Http\Request;
use Carbon\Carbon;


class SandlersController extends Controller
{
    /**
     * Create a new Sandlers Controller instance.
     *
     * @return void
     */
    public function __construct(Sandler $sandler = null, Parse $parse = null, Rate $rate = null, ExchangeRate $exchange = null)
    {
        $this->sandler = $sandler;
        $this->parse = $parse;
        $this->rate = $rate;
        $this->exchange = $exchange;
    }


    /**
     * Show the form for editing Sandler Debt
     *
     * @param \App\Sandler $sandler
     * @return \Illuminate\Http\Response
     */
    public function edit(Sandler $sandler)
    {
        $invoice = $sandler->invoice;
        $rate = $this->rate->get_rate();
        return view('sandlers.edit_sandler', compact('sandler', 'invoice', 'rate'));
    }

    /**
     * Update Sandler - paid status , insert middle exchange dollar, sandler percent, sandler dollar, sandler din, taxes percent and taxes din 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sandler $sandler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sandler $sandler)
    {   
        $this->validate($request, [
            'middle_ex_dollar' => 'required|numeric|digits_between:0,10|min:0',
            'sandler_din' => 'required|numeric|digits_between:0,10|min:0',
            'sandler_dollar' => 'required|numeric|digits_between:0,10|min:0',
            'ppo_din' => 'required|numeric|digits_between:0,10|min:0',
            'invoice_din' => 'required|numeric|digits_between:0,10|min:0',
            'sandler_percent' => 'required|numeric|digits_between:0,5|min:0',
            'ppo' => 'required|numeric|digits_between:0,5|min:0'

        ]);
        $request['is_paid'] = 1;
        $sandler->update($request->except(['_token', 'submit', 'invoice_din']));

        $request->session()->flash('message', 'Sandler dug i Porez po odbitku je izračunat za fakturu br. '.$sandler->invoice->invoice_number.' izdatu '.date("d.m.Y.",strtotime($sandler->issued_date)).' god.');

        return redirect('/sandler/debt');
    }

    /**
     * Display current Sandler Debt
     *
     * @return \Illuminate\Http\Response
     */
    public function debt()
    {
        /* Previous Month Name */
        $previous_month = $this->parse->get_previous_month_name();
        /* Exchange Dollar  */
        $exchange_dollar = $this->exchange->get_current_exchange_dollar();  
        /* PPO Percent*/
        $ppo = $this->rate->get_ppo_percent();        
        /* Sandler Percent */
        $sandler_percent = $this->rate->get_sandler_percent(); 
        /* Sandler Paying Date */
        $sandler_pay_day = $this->rate->get_sandler_paying_day(); 
        /* Current Date */
        $now = Carbon::now();
        /* First And Last Day Of The Previous Month  */
        $from_to_days = $this->parse->get_first_and_last_day_previous_month();
        /* Sandler Invoices Issued Last Month */ 
        $sandlers = $this->sandler->count_last_month_sandler_debt($from_to_days['from'], $from_to_days['to']);
        /* Total Sandler Invoices RSD Value Issued Last Month */
        $invoice_din_total = $this->sandler->get_last_month_sandler_debt($from_to_days['from'], $from_to_days['to']);
        /* Total Invoices Dollar Value */
        $invoice_dollar_total = round(( $invoice_din_total/$exchange_dollar),2);
        /* Total Sandler Debt Dollar Value */
        $sandler_dollar_total = round((($invoice_dollar_total*$sandler_percent)/100),2);
        /* Total PPO RSD Value */
        $ppo_din = round(($invoice_din_total*$ppo)/100,2);
        /* All Sandler Debt Not Paid With Paid Date Before Today */  
        $all_sandler = $this->sandler->get_sandler_debt_deadline_expired();

        return view('sandlers.debt', compact('previous_month', 'sandlers', 'exchange_dollar', 'ppo', 'sandler_percent', 'sandler_pay_day', 'now', 'invoice_din_total', 'invoice_dollar_total', 'sandler_dollar_total', 'ppo_din','all_sandler'));
    }


}
 