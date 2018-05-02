<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;

class RatesController extends Controller
{

    /**
     * Create a new Rates Controller instance.
     *
     * @return void 
     */
    public function __construct(Rate $rate = null)
    {
        $this->middleware(['auth','allow'],['admin', ['except' => ['edit', 'update']]]);

        $this->rate = $rate;
    }

    /**
     * Show the form for editing Taxes 
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_taxes()
    {
        $rate =$this->rate->get_rate();
        return view('rates.taxes', compact('rate'));
    }

    /**
     * Show the form for editing Sandler  
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_sandler()
    {
        $rate =$this->rate->get_rate();
        return view('rates.sandler', compact('rate'));
    }

    /**
     * Show the form for editing DISC/Devine  
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_disc_devine()
    {
        $rate =$this->rate->get_rate();
        return view('rates.disc_devine', compact('rate'));
    }


    /**
     * Update Taxes (PDV, PPO) and paying day.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rate $rate
     * @return \Illuminate\Http\Response
     */
    public function update_taxes(Request $request, Rate $rate)
    {
        $this->validate($request, [
            'pdv' => 'filled|numeric|min:0|max:100',
            'pdv_paying_day' => 'filled|integer|min:1|max:30',
            'ppo' => 'filled|numeric|min:0|max:100'
        ]);

        $rate->update($request->all());
        $request->session()->flash('message', 'Podaci su uspešno izmenjeni.');
            
        return back();
    }


    /**
     * Update Sandler and paying day.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rate $rate
     * @return \Illuminate\Http\Response
     */
    public function update_sandler(Request $request, Rate $rate)
    {
        $this->validate($request, [
            'sandler' => 'filled|numeric|min:0|max:100',
            'sandler_paying_day' => 'filled|integer|min:1|max:30',
        ]);

        $rate->update($request->all());
        $request->session()->flash('message', 'Podaci su uspešno izmenjeni.');

       return back();
    }


    /**
     * Update DISC, Devine and paying day.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rate $rate
     * @return \Illuminate\Http\Response
     */
    public function update_disc_devine(Request $request, Rate $rate)
    {
        $this->validate($request, [
            'disc' => 'filled|numeric|min:0|max:1000',
            'devine' => 'filled|numeric|min:0|max:1000',
            'dd_paying_day' => 'filled|integer|min:1|max:30',
        ]);

        $rate->update($request->all());
        $request->session()->flash('message', 'Podaci su uspešno izmenjeni.');

       return back();
    }


}
