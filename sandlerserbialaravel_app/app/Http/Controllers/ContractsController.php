<?php

namespace App\Http\Controllers;

use App\Article;
use App\Classes\Parse;
use App\Client;
use App\Contract;
use App\GlobalTraining;
use App\Participant;
use App\Payment;
use App\Template;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Storage;

class ContractsController extends Controller
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $validation_rules = [
        'contract_number' => 'required|numeric|digits_between:0,10|min:0|unique:contracts,contract_number',
        'value' => 'required|numeric|digits_between:0,10|min:0',
        'value_letters' => 'required|alpha_spaces|max:255',
        'advance' => 'required|numeric|digits_between:0,10|min:0|less_equal_then:value|advance_zero:payments,value',
        'payments' => 'required|numeric|digits_between:0,4|min:0|payments_zero:advance',
        'participants' => 'required|numeric|min:0|max:10000',
        'contract_date' => 'required|date_format:"Y-m-d"|after_and_today|before_or_equal:start_date|before_or_equal:end_date',
        'format_contract_date' => 'required|date_format:"d.m.Y."|after_and_today',
        'start_date' => 'date_format:"Y-m-d"|after_and_today|after_or_equal:contract_date',
        'format_start_date' => 'date_format:"d.m.Y."|after_and_today|after_or_equal:contract_date',
        'end_date' => 'date_format:"Y-m-d"|after_and_today|after_or_equal:contract_date|after_or_equal:start_date|after_or_equal:format_start_date',
        'format_end_date' => 'date_format:"d.m.Y."|after_and_today|after_or_equal:contract_date|after_or_equal:start_date|after_or_equal:format_start_date',
        'event_place' => 'max:255',
        'classes_number' => 'max:255',
        'work_dynamics' => 'max:255',
        'event_time' => 'max:255',
        'description' => 'max:5000',
    ];

    /**
     * Create a new Contracts Controller instance.
     *
     * @return void
     */
    public function __construct(Contract $contract = null, Client $client = null, GlobalTraining $global_training = null, Article $article = null, Template $template = null, Parse $parse = null)
    {
        $this->contract = $contract;
        $this->client = $client;
        $this->global_training = $global_training;
        $this->article = $article;
        $this->template = $template;
        $this->parse = $parse;
    }

    /**
     * Display In Progress Contracts - Ajax (Home-Page)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function in_progress(Request $request)
    {
        $title = "Ugovori u toku";
        $fa_icon = "fa-folder-open-o";
        $contracts = $this->contract->get_in_progress_contracts_pagination($pagination = 10);
        if ($request->ajax()) {
            return view('contracts.ajax_contracts', compact('contracts', 'title', 'fa_icon'));
        } else {
            return back();
        }
    }

    /**
     *  Display Unsigned Contracts - Ajax (Home-Page)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function unsigned(Request $request)
    {
        $title = "Nepotpisani Ugovori";
        $fa_icon = "fa-pencil-square-o";
        $contracts = $this->contract->get_unsigned_contracts_pagination($pagination = 10);
        if ($request->ajax()) {
            return view('contracts.ajax_contracts', compact('contracts', 'title', 'fa_icon'));
        } else {
            return back();
        }
    }

    /**
     *  Display Finished Contracts - Ajax (Home-Page)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function finished(Request $request)
    {
        $title = "Završeni Ugovori";
        $fa_icon = "fa-folder";
        $contracts = $this->contract->get_finished_contracts_pagination($pagination = 10);
        if ($request->ajax()) {
            return view('contracts.ajax_contracts', compact('contracts', 'title', 'fa_icon'));
        } else {
            return back();
        }
    }

    /**
     *  Display Broken Contracts - Ajax (Home-Page)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function broken(Request $request)
    {
        $title = "Raskinuti Ugovori";
        $fa_icon = "fa-ban";
        $contracts = $this->contract->get_broken_contracts_pagination($pagination = 10);
        if ($request->ajax()) {
            return view('contracts.ajax_contracts', compact('contracts', 'title', 'fa_icon'));
        } else {
            return back();
        }
    }

    /**
     * Show the form for creating new Clients Contract
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        /* Get Client (Legal or Individual) */
        $client = $this->client->get_client($client);
        $current_time = $this->parse->generate_current_time_session_key('single_submit');
        return view('contracts.create_contract', compact('client', 'current_time'));
    }

    /**
     * Store New Clients Contract
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $last_contract_number = $this->contract->get_last_contract_number();
        $next_contract_number = ++$last_contract_number;
        $request->request->add(['contract_number' => $next_contract_number]);

        $this->validation_rules['single_submit'] = 'numeric|size:' . $request->session()->get('single_submit');
        $this->validate($request, $this->validation_rules);

        DB::beginTransaction();

        try {
            $value = $request->input('value');
            $contract_date = $request->input('contract_date');
            $advance = $request->input('advance');
            $payments = $request->input('payments');

            /* Insert Contract */
            $contract_id = Contract::create(array_merge(
                $request->except(['_token', 'submit', 'format_contract_date', 'format_start_date', 'format_end_date']),
                [
                    'contract_number' => $next_contract_number,
                    'rest' => $request->input('value'),
                    'legal_status_id' => $client->legal_status_id,
                    'client_id' => $client->id,
                ]
            ))->id;

            /* Insert Participants Based On The Participants Number */
            for ($i = 0; $i < $request->input('participants'); $i++) {
                $participant_id = Participant::create()->id;
                /* Insert Foreign Keys Of Contract And Participant In ContractParticipant Table*/
                DB::table('contract_participant')->insert(['contract_id' => $contract_id, 'participant_id' => $participant_id]);
            }
            /* Insert Payments Based On The Payments Number */
            if ($advance > '0') {
                /* If Advance Exists Insert Like Payment */
                Payment::create(['value_euro' => $advance, 'pay_date' => $contract_date, 'pay_date_desc' => 'odmah po potpisivanju Ugovora na ime avansa', 'description' => 'Avans', 'is_advance' => '1', 'contract_id' => $contract_id]);
            }
            $check_total = 0;
            for ($i = 1; $i <= $payments; $i++) {
                $total = $value - $advance;
                $value_euro = round($total / $payments);
                $check_total += $value_euro;
                /* Last Payment Value Equalization */
                if ($payments == $i) {
                    if ($check_total > $total) {
                        $value_euro -= ($check_total - $total);
                    } elseif ($check_total < $total) {
                        $value_euro += ($total - $check_total);
                    }
                }
                $pay_date = $this->get_payment_date($contract_date, $i);
                $pay_date_desc = "po završetku " . $i . ". meseca Projekta";
                $description = $this->get_payment_description($pay_date);
                Payment::create(['value_euro' => $value_euro, 'pay_date' => $pay_date, 'pay_date_desc' => $pay_date_desc, 'description' => $description, 'contract_id' => $contract_id]);
            }

            /* Remove Single Submit Session */
            $request->session()->forget('single_submit');

            DB::commit();
            $request->session()->flash('message', 'Ugovor broj ' . $next_contract_number . ' je uspešno kreiran.');
        } catch (Exception $e) {
            DB::rollback();
            $request->session()->flash('message', 'Greška! Ugovor nije kreiran.');
        }

        return redirect('/client/' . $client->id);
    }

    /**
     * Display Contract
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        /* Get Client (Legal or Individual) */
        $client = $this->client->get_client($contract->client);
        /* Contract Status Table */
        $contract_status = $contract->contract_status;
        return view('contracts.show_contract', compact('contract', 'client', 'contract_status'));
    }

    /**
     * Show the form for editing Contract
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        /* Get Client (Legal or Individual) */
        $client = $this->client->get_client($contract->client);
        return view('contracts.edit_contract', compact('contract', 'client'));
    }

    /**
     * Update Contract
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {

        $request->request->add(['contract_number' => $contract->contract_number]);
        $this->validation_rules['contract_number'] = "required|numeric|digits_between:0,10|min:0|unique:contracts,contract_number,{$contract->id}";

        $this->validate($request, $this->validation_rules);

        DB::beginTransaction();

        try {
            /* Contract Unsigned Status */
            if ($contract->contract_status_id == 1) {
                /* Update Contract */
                $contract->update(array_merge(
                    $request->except(['contract_number', '_token', 'submit', 'format_contract_date', 'format_start_date', 'format_end_date']),
                    [
                        'rest' => $request->input('value'),
                    ]
                ));
                /* Delete Previous Contract Payments */
                $contract->payment()->delete();
                /* Delete Previous Contract Participants */
                $contract->participant()->delete();

                $value = $request->input('value');
                $contract_date = $request->input('contract_date');
                $advance = $request->input('advance');
                $payments = $request->input('payments');

                /* Insert Participants Based On Participants Number */
                for ($i = 0; $i < $request->input('participants'); $i++) {
                    $participant_id = Participant::create()->id;
                    /* Insert Foreign Keys Of Contract And Participant In ContractParticipant Table*/
                    DB::table('contract_participant')->insert(['contract_id' => $contract->id, 'participant_id' => $participant_id]);
                }

                /* Insert Payments Based On Payments Number */
                if ($advance > '0') {
                    /* If Advance Exists Insert Like Payment */
                    Payment::create(['value_euro' => $advance, 'pay_date' => $contract_date, 'pay_date_desc' => 'odmah po potpisivanju Ugovora na ime avansa', 'description' => 'Avans', 'is_advance' => '1', 'contract_id' => $contract->id]);
                }
                $check_total = 0;
                for ($i = 1; $i <= $payments; $i++) {
                    $total = $value - $advance;
                    $value_euro = round($total / $payments);
                    $check_total += $value_euro;
                    /* Last Payment Value Equalization */
                    if ($payments == $i) {
                        if ($check_total > $total) {
                            $value_euro -= ($check_total - $total);
                        } elseif ($check_total < $total) {
                            $value_euro += ($total - $check_total);
                        }
                    }
                    $pay_date = $this->get_payment_date($contract_date, $i);
                    $pay_date_desc = "po završetku " . $i . ". meseca Projekta";
                    $description = $this->get_payment_description($pay_date);
                    Payment::create(['value_euro' => $value_euro, 'pay_date' => $pay_date, 'pay_date_desc' => $pay_date_desc, 'description' => $description, 'contract_id' => $contract->id]);
                }

                DB::commit();
                $request->session()->flash('message', 'Ugovor je uspešno izmenjen.');
            }
        } catch (Exception $e) {
            DB::rollback();
            $request->session()->flash('message', 'Greška! Ugovor nije izmenjen.');
        }

        return back();
    }

    /**
     * Sing Contract (Set Status To In Progress Only If Current Status Is Unsigned)
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function sign(Contract $contract)
    {
        DB::beginTransaction();

        try {
            /* Contract PDF Filename */
            $filename = 'Ugovor_' . $contract->contract_number . '.pdf';
            /* PDF File Path */
            $pdf_file = $this->parse->get_pdf_contract_path(true, $contract->client_id, $contract->id, $filename);
            if (!file_exists($pdf_file)) {
                Session::flash('message', 'Ugovor broj ' . $contract->contract_number . ' nije odštampan u PDF formatu!');
                return redirect('/contract/' . $contract->id);
            }

            /* Contract Unsigned Status */
            if ($contract->contract_status_id == 1) {
                /* Get Client Status Id Based On Status Name */
                $client_status_id = $this->parse->get_client_status_id_by_name('active');
                /* Set Client Status - Active */
                $this->client->set_client_status($contract->client, $client_status_id);
                /* Message Based On Legal Status */
                $message = ($contract->legal_status_id == 1) ? 'potpisan' : 'dogovoren';
                /* Get Contract Status Id Based On Status Name */
                $contract_status_id = $this->parse->get_contract_status_id('in_progress');
                /* Set Contract Status In Progress */
                $this->contract->set_contract_status($contract, $contract_status_id);
                /* Get Client (Legal/Individual) */
                $client = $this->client->get_client($contract->client);
                /* Set Client's Closing Date */
                if (!$client->closing_date) {
                    $this->client->set_closing_date($client);
                }

                DB::commit();
                Session::flash('message', 'Ugovor broj ' . $contract->contract_number . ' je ' . $message . '.');
            }
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('message', 'Greška! Ugovor nije potpisan.');
        }

        return redirect('/client/' . $contract->client_id);
    }

    /**
     * Show the form for editing Contract Desciption
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function add_description(Contract $contract)
    {
        /* Get Client (Legal or Individual) */
        $client = $this->client->get_client($contract->client);
        return view('contracts.add_description', compact('contract', 'client'));
    }

    /**
     * Update Contract Description
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update_description(Request $request, Contract $contract)
    {
        $this->validate($request, ['description' => 'max:5000']);

        if ($contract->update(['description' => $request->input('description')])) {
            $request->session()->flash('message', 'Opis Ugovora je uspešno izmenjen.');
        } else {
            $request->session()->flash('message', 'Greška! Opis Ugovora je nije izmenjen.');
        }
        return back();
    }

    /**
     * Break Up Contract (Set Status To Broken Only If Current Status Is In Progress)
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function break_up(Contract $contract)
    {
        DB::beginTransaction();

        try {
            /* Contract In Progress Status */
            if ($contract->contract_status_id == 2) {
                /* Number In Progress Client Contracts Except Passed Contract */
                $client_contracts = $this->contract->count_clients_other_in_progress_contracts($contract);

                if ($client_contracts == 0) {
                    /* Get Client Status Id Based On Status Name */
                    $client_status_id = $this->parse->get_client_status_id_by_name('inactive');
                    /* Set Client Status - Inctive */
                    $this->client->set_client_status($contract->client, $client_status_id);
                }

                /* Get Contract Status Id Based On Status Name */
                $contract_status_id = $this->parse->get_contract_status_id('broken');
                /* Set Contract Status Broken */
                $this->contract->set_contract_status($contract, $contract_status_id);

                DB::commit();
                Session::flash('message', 'Ugovor broj ' . $contract->contract_number . ' je raskinut.');
            }
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('message', 'Greška! Ugovor nije raskinut.');
        }

        return redirect('/client/' . $contract->client_id);
    }

    /**
     * Delete Contract (With Payments, Participants and Stored Files Only If Current Status Is Unsigned)
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        DB::beginTransaction();

        try {
            /* Contract Unsigned Status */
            if ($contract->contract_status_id == 1) {
                /* Delete Payments */
                $contract->payment()->delete();
                /* Delete Participants */
                $contract->participant()->delete();
                /* Delete Contract */
                $contract->delete();
                /* Pdf Contract Directory */
                $directory = $this->parse->get_pdf_contract_path(false, $contract->client_id, $contract->id, '');
                /* Pdf Filename */
                $filename = 'Ugovor_' . $contract->contract_number . '.pdf';
                /* Pdf Contract File */
                $pdf_file = $directory . $filename;
                /* Delete Contract Directory If Pdf File Exists */
                if (Storage::disk('local')->exists($pdf_file)) {
                    Storage::disk('local')->deleteDirectory($directory);
                }

                DB::commit();
                Session::flash('message', 'Ugovor je uspešno obrisan.');
            }
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('message', 'Greška! Ugovor nije obrisan.');
        }

        return redirect('/client/' . $contract->client_id);
    }

    /**
     * Display Custom Contract (PDF)
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function custom(Contract $contract)
    {
        /* Contract Unsigned Status */
        if ($contract->contract_status_id == 1) {
            /* Get Client (Legal or Individal) */
            $client_array = $this->client->get_client($contract->client)->toArray();
            /* Contract Client Array Fof PDF View */
            $client = $this->parse->get_client_contract_pdf($contract->client->legal_status_id, $client_array);
            /* Contract Payments Array */
            $payments = $contract->payment->toArray();
            /* Contract Participants Array */
            $participants = $contract->participant->toArray();
            /* Contract Array */
            $contract = $contract->toArray();
            /* Global Training Array */
            $gt = $this->global_training->get_global_training()->toArray();
            /* Contract Html */
            $html = $contract['html'];
            /* Articles */
            $article = $this->article->get_articles_html();
            /* Template Options */
            $template = $this->template->get_template_options();

            return view('contracts.custom', compact('contract', 'client', 'payments', 'participants', 'gt', 'html', 'article', 'template'));
        } else {
            return back();
        }
    }

    /**
     * Returns Next Payment Date Based On The Date Plus Payment Month Number
     *
     * @param  string $date
     * @param  string $payment_month_number
     * @return  string
     */
    public function get_payment_date($date, $payment_month_number)
    {
        $d = date("d", strtotime($date));
        $m = date("m", strtotime($date));
        $y = date("Y", strtotime($date));
        if ($d == '29' || $d == '30' || $d == '31') {
            $d = '01';
            $m++;
        }
        $new_date_time = strtotime($y . '-' . (string) $m . '-' . $d);
        $next_month_date = date("Y-m-d", strtotime("+" . $payment_month_number . " month", $new_date_time));
        return $next_month_date;
    }

    /**
     * Returns Payment Month Name Description Based On The Date
     *
     * @param  string $date
     * @return  string
     */
    public function get_payment_description($date)
    {
        $months = array('01' => 'Januar', '02' => 'Februar', '03' => 'Mart', '04' => 'April', '05' => 'Maj', '06' => 'Jun', '07' => 'Jul', '08' => 'Avgust', '09' => 'Septembar', '10' => 'Oktobar', '11' => 'Novembar', '12' => 'Decembar');
        $note = "Fond časova za mesec ";
        $day = date('d', strtotime($date));
        $month = date("m", strtotime($date));
        if ($month == '01') {
            $month = '12';
        } elseif ($day < '15' && $month != '01') {
            $month--; //fond casova za tekuci ili prosli mesec
        }
        foreach ($months as $month_number => $month_name) {
            if ($month_number == $month) {
                $note = $note . $month_name;
                return $note;
            }
        }
    }
}
