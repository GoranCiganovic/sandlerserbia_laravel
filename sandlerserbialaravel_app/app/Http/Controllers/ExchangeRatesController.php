<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRatesController extends Controller
{

    /**
     * Create a new ExchangeRates Controller instance.
     *
     * @return void
     */
    public function __construct(ExchangeRate $exchange = null)
    {
        $this->exchange = $exchange;
    }
 
    /**
     * Dislpay All Exchage Rates
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exchange = $this->exchange->get_all_exchange_rate();
        return view('exchange_rates.exchange', compact('exchange'));
    }

    /**
     * Show the form for editing Exchange Rate
     *
     * @param \App\ExchageRate $exchange
     * @return \Illuminate\Http\Response
     */
    public function edit(ExchangeRate $exchange)
    {
        return view('exchange_rates.edit_exchange', compact('exchange'));
    }

    /**
     * Update Exchange Rate
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExchangeRate $exchange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExchangeRate $exchange)
    {
        $this->validate($request, [
            'exchange_value' => 'required|numeric|digits_between:0,10|min:0',
        ]);

        $exchange_value = $request->input('exchange_value');
        $exchange->update(['value' => $exchange_value]);

        $request->session()->flash('message', 'Valuta ' . $exchange->currency . ' je uspešno izmenjena.');

        return back();
    }
}
