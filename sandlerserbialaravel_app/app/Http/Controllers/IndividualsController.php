<?php

namespace App\Http\Controllers;

use App\Individual;
use App\Classes\Parse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Client;

class IndividualsController extends Controller
{
    /**
     * Create a new Individuals Controller instance.
     *
     * @return void
     */
    public function __construct(Parse $parse = null)
    {
        $this->parse = $parse;
    }

    /**
     * Show the form for creating a new Individual
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_time = $this->parse->generate_current_time_session_key('single_submit');
        return view('suspects.create_individual', compact('current_time'));
    }

    /**
     * Store New Individual Client
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha_spaces|min:2|max:45',
            'last_name' => 'required|alpha_spaces|min:2|max:45',
            'phone' => 'required|numeric_spaces|between:6,30|unique:individuals,phone',
            'email' => "email|min:7|max:150", 
            'jmbg' => 'numeric|digits_between:13,45|unique:individuals,jmbg',
            'id_card' => 'numeric|digits_between:6,45|unique:individuals,id_card',
            'works_at' => 'max:45',
            'address' => 'min:2|max:150',
            'county' => 'alpha_spaces|min:2|max:45',
            'postal' => 'numeric|digits:5',
            'city' => 'alpha_spaces|min:2|max:45',
            'comment' => 'max:5000',
            'single_submit'  =>'numeric|size:'.$request->session()->get('single_submit')    
        ]);
        /* Unique Nullable Columns */
        $request['jmbg'] = $request->input('jmbg') ? $request->input('jmbg') : null;
        $request['id_card'] = $request->input('id_card') ? $request->input('id_card') : null;

        DB::beginTransaction();

        try {
            /* Create Client and Individual Suspect */ 
            Individual::create(array_merge($request->all(), ['client_id' => Client::create(['legal_status_id' => 2])->id]));
            /* Remove Single Submit Session */
            $request->session()->forget('single_submit');

            DB::commit();
            $request->session()->flash('message', 'Suspect '.$request->input('first_name').' '.$request->input('last_name').' je uspešno unet.');
                return back();
           
        }catch(Exception $e){

            DB::rollback();
            $request->session()->flash('message', 'Greška!');

        }

        return back();
    }

    /**
     * Update Individual profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Individual $individual)
    {
        $this->validate($request, [ 
            'first_name' => 'required|alpha_spaces|min:2|max:45',
            'last_name' => 'required|alpha_spaces|min:2|max:45',
            'phone' => "required|numeric_spaces|between:6,30|unique:individuals,phone,{$individual->id}",
            'email' => "email|min:7|max:150", 
            'jmbg' => "numeric|digits_between:13,45|unique:individuals,jmbg,{$individual->id}",
            'id_card' => "numeric|digits_between:6,45|unique:individuals,id_card,{$individual->d}",
            'works_at' => 'max:45',
            'address' => 'min:2|max:150',
            'county' => 'alpha_spaces|min:2|max:45',
            'postal' => 'numeric|digits:5',
            'city' => 'alpha_spaces|min:2|max:45',
            'comment' => 'max:5000' 
        ]);

        /* Unique Nullable Columns */
        $request['jmbg'] = $request->input('jmbg') ? $request->input('jmbg') : null;
        $request['id_card'] = $request->input('id_card') ? $request->input('id_card') : null;

        $individual->update($request->except('_token'));

        $request->session()->flash('message', 'Profil je uspešno izmenjen.');

        return back();
    }


    /**
     * Update Individual Meeting Date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function add_meeting_date(Request $request, Individual $individual)
    {
        $this->validate($request, [ 
            'format_meeting_date' => 'date_format:"d.m.Y. H:i"',
            'meeting_date' => 'date_format:"Y-m-d H:i"'
        ]);

        try {

            if($individual->client_status_id == 3){

                $individual->update($request->all());

                $request->session()->flash('message', 'Datum sastanka je uspešno unet.');
            }
            
        } catch (Exception $e) {
          
            $request->session()->flash('message', 'Greška!');
        }

        return back();
    }


}
