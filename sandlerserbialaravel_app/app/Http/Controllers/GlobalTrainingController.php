<?php

namespace App\Http\Controllers;

use App\GlobalTraining;
use Illuminate\Http\Request;


class GlobalTrainingController extends Controller
{
    /**
     * Create a new GlobalTraining Controller instance.
     *
     * @return void
     */
    public function __construct(GlobalTraining $global_training = null)
    {
        $this->global_training = $global_training;
    }

    /**
     * Show the form for editing Global Training
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $global_training = $this->global_training->get_global_training();
        return view('global_training.edit', compact('global_training'));
    }

     /**
     * Update Global Training
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GlobalTraining $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GlobalTraining $id)
    {
    	
        $this->validate($request, [
            'name' => 'filled|min:1|max:150',
            'representative' => 'filled|alpha_spaces|min:2|max:45',
            'phone' => 'filled|numeric_spaces|between:6,30',
            'email' => "filled|email|min:7|max:150", 
            'website' => 'filled|min:4|max:45',
            'address' => 'filled|min:2|max:150',
            'county' => 'filled|alpha_spaces|min:2|max:45',
            'postal' => 'filled|numeric|digits:5',
            'city' => 'filled|alpha_spaces|min:2|max:45',
            'bank' => 'filled|max:45',
            'account' => 'filled|numeric|digits_between:6,45',
            'pib' => 'filled|numeric|digits_between:6,45',
            'identification' => 'filled|numeric|digits_between:6,45'
        ]);

        $id->update($request->all());

        $request->session()->flash('message', 'Podaci su uspešno izmenjeni.');

        return back();
    }
}
