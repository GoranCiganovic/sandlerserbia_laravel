<?php

namespace App\Http\Controllers;

use App\DiscDevine;
use App\Rate;
use App\ExchangeRate;
use App\Classes\Parse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiscDevinesController extends Controller
{

    /**
     * Create a new DiscDevines Controller instance.
     *
     * @return void
     */
    public function __construct(DiscDevine $disc_devine = null, Rate $rate = null, ExchangeRate $exchange = null, Parse $parse = null)
    {
        $this->disc_devine = $disc_devine;
        $this->rate = $rate;
        $this->exchange = $exchange;
        $this->parse = $parse;
    }

    /**
     * Show the form for editing DISC/Devine
     *
     * @param \App\DiscDevine $disc_devine
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscDevine $disc_devine)
    {
        $participant = $disc_devine->participant;
        $ppo = $this->rate->get_ppo_percent();
        return view('disc_devines.edit_disc_devine', compact('disc_devine', 'participant','ppo'));
    }

    /**
     * Update DISC/Devine - paid status , insert middle exchange dollar, value din, taxes percent and taxes din 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscDevine $disc_devine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscDevine $disc_devine)
    {      
        $this->validate($request, [
            'middle_ex_dollar' => 'required|numeric|digits_between:0,10|min:0',
            'dd_din' => 'required|numeric|digits_between:0,10|min:0',
            'ppo_din' => 'required|numeric|digits_between:0,10|min:0',
            'dd_dollar' => 'required|numeric|digits_between:0,10|min:0',
            'ppo' => 'required|numeric|digits_between:0,5|min:0'

        ]);
        $request['is_paid'] = 1;
        $disc_devine->update($request->except(['_token', 'submit', 'dd_dollar']));

        $request->session()->flash('message', 'Porez po odbitku je izračunat za DISC/Devine test - '.$disc_devine->participant->name.' urađen '.date("d.m.Y.",strtotime($disc_devine->make_date)).' god.');

        return redirect('/disc_devine/debt');
    }

    /**
     * Display current DISC/Devine Debt
     *
     * @return \Illuminate\Http\Response
     */
    public function debt()
    {
        /* Previous Month Name */
        $previous_month = $this->parse->get_previous_month_name();
        /* First And Last Day Of The Previous Month  */
        $from_to_days = $this->parse->get_first_and_last_day_previous_month();
        /* DISC/Devine Tests Done Last Month */ 
        $disc_devines = $this->disc_devine->count_last_month_disc_devine_debt($from_to_days['from'], $from_to_days['to']);
        /* Exchange Dollar  */
        $exchange_dollar = $this->exchange->get_current_exchange_dollar();
        /* PPO Percent*/
        $ppo = $this->rate->get_ppo_percent();
        /* DISC/Devine Paying Date */
        $dd_pay_day = $this->rate->get_dd_paying_day();
        /* Current Date */
        $now = Carbon::now();
        /* Total DISC/Devine Dollar Value Made Last Month */
        $dd_dollar_total = $this->disc_devine->get_last_month_disc_devine_debt($from_to_days['from'], $from_to_days['to']);
        /* Total DISC/Devine RSD Value */
        $dd_din_total = round(($exchange_dollar*$dd_dollar_total),2);
        /* Total PPO RSD Value */
        $ppo_din = round(($dd_din_total*$ppo)/100,2);
        /* All DISC/Devine Tests Not Paid With Paid Date Before Today */
        $all_disc_devine = $this->disc_devine->get_disc_devine_debt_deadline_expired();

        return view('disc_devines.debt', compact('previous_month', 'disc_devines','exchange_dollar', 'ppo', 'dd_pay_day', 'now', 'dd_dollar_total', 'dd_din_total', 'ppo_din','all_disc_devine'));
    }




}
