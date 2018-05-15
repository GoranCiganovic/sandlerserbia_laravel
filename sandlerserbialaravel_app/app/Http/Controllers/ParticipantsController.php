<?php

namespace App\Http\Controllers;

use App\Classes\Parse;
use App\Contract;
use App\Participant;
use App\Rate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class ParticipantsController extends Controller
{

    /**
     * Validation Participant Rules
     *
     * @var array
     */
    protected $validation_rules = [
        'name' => 'required|alpha_spaces|min:2|max:255',
        'position' => 'min:2|max:255',
        'email' => "email|min:7|max:255",
        'phone' => 'numeric_spaces|between:6,30',
        'format_dd_date' => 'date_format:"d.m.Y."',
        'dd_date' => 'date_format:"Y-m-d"',
    ];

    /**
     * Create a new Participants Controller instance.
     *
     * @return void
     */
    public function __construct(Parse $parse = null, Rate $rate = null)
    {
        $this->parse = $parse;
        $this->rate = $rate;
    }

    /**
     * Display Contract Participants
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function index(Contract $contract)
    {
        $participants = $contract->participant_paginate($contract, $paginate = 10);
        return view('participants.participants', compact('contract', 'participants'));
    }

    /**
     * Show the form for creating new Contract Participant
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function create(Contract $contract)
    {
        $current_time = $this->parse->generate_current_time_session_key('single_submit');
        return view('participants.create_participant', compact('contract', 'current_time'));
    }

    /**
     * Store New Contract Participant
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Contract $contract)
    {
        $this->validation_rules['single_submit'] = 'numeric|size:' . $request->session()->get('single_submit');
        $this->validate($request, $this->validation_rules);

        DB::beginTransaction();

        try {
            if ($request->input('name') != '' && $request->input('email') != '') {
                $exist_participant = Participant::where('name', $request->input('name'))
                    ->where('email', $request->input('email'))
                    ->first();
                if ($exist_participant) {
                    $request['dd_date'] = $exist_participant->dd_date;
                }
            }

            $contract->update(['participants' => ++$contract->participants]);

            $participant_id = Participant::create($request->all())->id;

            DB::table('contract_participant')->insert(['contract_id' => $contract->id, 'participant_id' => $participant_id]);

            /* Remove Single Submit Session */
            $request->session()->forget('single_submit');

            DB::commit();
            $request->session()->flash('message', 'Učesnik ' . $request->input('name') . ' je uspešno dodat.');
        } catch (Exception $e) {
            DB::rollback();
            $request->session()->flash('message', 'Greška! Učesnik nije dodat.');
        }

        return redirect('/participants/' . $contract->id);
    }

    /**
     * Show the form for editing Participant
     *
     * @param  \App\Contract  $contract
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract, Participant $participant)
    {
        return view('participants.edit_participant', compact('contract', 'participant'));
    }

    /**
     * Update Participant (if store disc devine date, store DISC/Devine, if not, delete DISC/Devine)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participant $participant)
    {

        $this->validate($request, $this->validation_rules);

        DB::beginTransaction();

        try {
            if ($request->input('format_dd_date') == '') {
                $request['dd_date'] = null;
                if ($participant->disc_devine) {
                    $participant->disc_devine->delete();
                }
            }

            if ($request->input('name') != '' && $request->input('email') != '') {
                $exist_participant = Participant::where([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                ])->first();

                if ($exist_participant && $exist_participant->dd_date) {
                    $request['format_dd_date'] = $exist_participant->dd_date;
                    $request['dd_date'] = $exist_participant->dd_date;
                }
            }

            if ($request->input('format_dd_date')) {
                $rates = $this->rate->get_rate();
                $data = [
                    'disc_dollar' => $rates->disc,
                    'devine_dollar' => $rates->devine,
                    'dd_dollar' => $rates->disc_devine,
                    'make_date' => $request['dd_date'],
                    'paid_date' => $this->parse->get_next_month_paying_date($rates->dd_paying_day),
                ];
                if ($participant->disc_devine) {
                    /* Update */
                    $participant->disc_devine->update($data);
                } else {
                    /* Insert */
                    $participant->disc_devine()->insert(
                        array_merge($data, ['participant_id' => $participant->id])
                    );
                }
            }

            $participant->update($request->except('format_dd_date', '_token', 'submit'));

            DB::commit();
            $request->session()->flash('message', 'Podaci su uspešno izmenjeni.');
        } catch (Exception $e) {
            DB::rollback();
            $request->session()->flash('message', 'Greška! Podaci nisu izmenjeni.');
        }

        return back();
    }

    /**
     * Delete Participant  (if is stored disc devine date, delete from DISC/Devine)
     *
     * @param  \App\Contract  $contract
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract, Participant $participant)
    {

        if ($participant->dd_date != null) {
            Session::flash('message', 'Nije dozvoljeno brisanje učesnika zbog urađenog DISC/Devine testa!');
            return back();
        } else {
            DB::beginTransaction();

            try {
                $disc_devine = $participant->disc_devine;
                if ($disc_devine) {
                    $participant->disc_devine->delete();
                }
                $contract->update(['participants' => --$contract->participants]);
                $participant->delete();

                DB::commit();
                Session::flash('message', 'Uspešno je obrisan učesnik ' . $participant->name . '.');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash('message', 'Greška! Neuspešno brisanje učesnika ' . $participant->name . '.');
            }

            return redirect('/participants/' . $contract->id);
        }
    }
}
