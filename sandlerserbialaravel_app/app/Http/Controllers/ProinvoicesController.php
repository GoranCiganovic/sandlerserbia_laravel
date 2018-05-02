<?php

namespace App\Http\Controllers;

use App\Proinvoice;
use App\Invoice;
use App\Rate;
use App\Client;
use App\Contract;
use App\Payment;
use App\Sandler;
use App\Classes\Parse;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use Illuminate\Support\Facades\DB;
use Session;
use Exception;
use Storage;


class ProinvoicesController extends Controller
{
    /**
     * Create a new Proinvoices Controller instance.
     *
     * @return void
     */
    public function __construct(Proinvoice $proinvoice = null, Invoice $invoice = null, Rate $rate = null, Client $client = null, Contract $contract = null, Payment $payment = null, Sandler $sandler = null, Parse $parse=null)
    {
        $this->proinvoice = $proinvoice;
        $this->invoice = $invoice;
        $this->rate = $rate;
        $this->client = $client;
        $this->contract = $contract;
        $this->payment = $payment;
        $this->sandler = $sandler;
        $this->parse = $parse;
    }

    /**
     * Display Pronvoices for Issuing Today - Ajax (Home-Page) (Payment Paying Date on Today, Not Issued, Not Paid, Is Advance and Contract Status In Progress)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */ 
    public function issue_today(Request $request)
    {
        $title = "Avans za koji je potrebno izdati profakturu";
        $proinvoices = $this->payment->get_payments_advance_issue_today_pagination($pagination = 10);
        if ($request->ajax()) {
             return view('invoices.ajax_proinvoices.issue_today', compact('proinvoices','title'));
        }else{
            return back();
        }
    }

    /**
     * Display Created Pronvoices - Confirm Issued Status - Ajax (Home-Page) (Proinvoice Not Paid and Not Issued)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function confirm_issued(Request $request)
    {
        $title = "Profakture za koje je potrebno potvrditi da su izdate";
        $proinvoices = $this->proinvoice->get_proinvoices_not_issued_not_paid_pagination($pagination = 10);
        if ($request->ajax()) {
             return view('invoices.ajax_proinvoices.confirm_issued', compact('proinvoices','title'));
        }else{
            return back();
        }
    }


    /**
     * Display Issued Proinvoices - Confirm Paid Status - Ajax (Home-Page) (Proinvoice Is Issued and Not Paid)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function confirm_paid(Request $request)
    {
        $title = "Izdate profakture za koje je potrebno potvrditi da su plaćene";
        $proinvoices = $this->proinvoice->get_proinvoices_issued_not_paid_pagination($pagination = 10);
        if ($request->ajax()) {
             return view('invoices.ajax_proinvoices.confirm_paid', compact('proinvoices','title'));
        }else{
            return back();
        }
    }


    /**
     * Store New Proinvoice ,store Invoice Associated With Created Proinvoice and Set Payment Status Issued Associated With Created Proinvoice/Invoice
     *
     * @param  \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request, Contract $contract, Payment $payment)
    {   
        /* Contract Status In Progress */
        if($contract->contract_status_id == 2){

            $rules = array_merge($request->rules(),['single_submit'=>'numeric|size:'.$request->session()->get('single_submit')]);
            $this->validate($request, $rules);

            DB::beginTransaction();

            try {
                /* Type (Invoice or Proinvoice) */
                $type = $this->parse->get_payment_type('proinvoice');
                /* Next Number - Proinvoice Number And Serial Number (Legal or Individaul) */
                $invoice_number_arr = $this->parse->next_invoice_proinvoice_number($contract->legal_status_id, $type);
                /* Insert Proinvoice */
                $proinvoice_id = Proinvoice::create(array_merge($request->except($request->store_except()), [
                    'value_euro' => $payment->value_euro,
                    'serial_number' => $invoice_number_arr['serial_number'], 
                    'proinvoice_number' => $invoice_number_arr['proinvoice_number'],
                    'payment_id' => $payment->id,
                    'contract_id' => $contract->id,
                    'client_id' => $contract->client_id            
                ]))->id;
                /* Insert Invoice Associated With Proinvoice */
                Invoice::create(array_merge($request->except($request->store_except()), [
                    'value_euro' => $payment->value_euro,
                    'proinvoice_id' => $proinvoice_id,
                    'payment_id' => $payment->id,
                    'contract_id' => $contract->id,
                    'client_id' => $contract->client_id             
                ]));


                DB::commit();
                Session::flash('message','Profaktura broj '.$invoice_number_arr['proinvoice_number'].' je kreirana.'); 

            } catch (Exception $e) {
                
                DB::rollback();
                Session::flash('message','Greška! Profaktura nije kreirana.');
            }
        }else{
             Session::flash('message','Profaktura nije kreirana jer je Ugovor '.$contract->contract_status->name.'.');
        }

        return redirect('/payment/'.$contract->id.'/'.$payment->id);
    }


    /**
     * Update Proinvoice and Invoice Associated With Updated Proinvoice
     *
     * @param  \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, Contract $contract, Payment $payment, Proinvoice $proinvoice)
    {
        $this->validate($request, $request->rules());

        DB::beginTransaction();

        try {
            /* Update Proinvoice */
            Proinvoice::where('id', $proinvoice->id)->update($request->except($request->update_except()));
            /* Update Invoice Associated With Proinvoice */
            Invoice::where('proinvoice_id', $proinvoice->id)->update($request->except($request->update_except()));

            DB::commit();
            Session::flash('message','Profaktura broj '.$proinvoice->proinvoice_number.' je izmenjena.'); 

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Profaktura nije izmenjena.');
        }

        return back();
    }


    /**
     * Issued Proinvoice (Set Status to Issued)
     *
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function issued(Contract $contract, Payment $payment, Proinvoice $proinvoice)
    {
        try {
            /* Set Proinvoice Status Issued */
            $this->proinvoice->set_proinvoice_issued($proinvoice);
            /* Set Status Issued For Payment Associated With Proinvoice */
            $this->payment->set_payment_issued($payment);

            Session::flash('message','Profaktura broj '.$proinvoice->proinvoice_number.' je izdata.'); 

            return redirect('/payment/'.$contract->id.'/'.$payment->id);

        } catch (Exception $e) {
            
            Session::flash('message','Greška kod promene statusa profakture u izdata!');
            return back();
        }   
    }    

    /**
     * Paid Proinvoice (Set Proinvoice Status Paid, Store Proinvoice Paid Date, Set Invoice Associated With Proinvoice Status Paid ,Store Invoice Associated With Proinvoice Paid Date, Set Payment Associated With Proinvoice/Invoice Status Paid, Update Contract Rest and Paid, Update Client Status (if there are no client contracts In Progress), Create Sandler Debt for Legal Clients)
     *
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function paid(Contract $contract, Payment $payment, Proinvoice $proinvoice)
    {
        DB::beginTransaction();

        try {
            /* Issued Proinvoice */
            if($proinvoice->is_issued == '1'){

                /* PDV Paying Day */
                $pdv_paying_day = $this->rate->get_pdv_paying_day();
                /* Next Month PDV Paying Date */
                $pdv_paying_date = $this->parse->get_next_month_paying_date($pdv_paying_day);
                /* Set Proinvoice Paid Status, Paid Date - Today, PDV Paying Date */
                $this->proinvoice->set_proinvoice_paid($proinvoice, $pdv_paying_date);
                /* Set Payment Associated With Proinvoce/Invoice Paid Status  */
                $this->payment->set_payment_paid($payment);
                /* Set Invoice Associated With Proinvoce Paid Status, Paid Date - Today, PDV Paying Date */
                $invoice =  $this->invoice->get_invoice_by_proinvoice_id($proinvoice->id);
                $this->invoice->set_invoice_paid($invoice, $pdv_paying_date);
                /* Update Contract Paid and Rest Based On Proinvoice Value */
                $paid = $contract->paid + $proinvoice->value_euro;
                $rest = $contract->rest - $proinvoice->value_euro;
                $this->contract->update_contract_paid_and_rest($contract, $paid, $rest);
                /* Contract Rest For Payment */
                if($rest == '0'){
                    /* Get Contract Status Id Based On Status Name */
                    $contract_status_id = $this->parse->get_contract_status_id('finished');
                    /* Set Contract Status Finished */ 
                    $this->contract->set_contract_status($contract, $contract_status_id);
                    /* Number Of Client's In Progress Contracts */
                    $in_progress = $this->contract->count_clients_in_progress_contracts($contract->client_id);
                    /* Set Client (Legal/Individual) Status Inactive */
                    if($in_progress == 0){
                        /* Get Client Status Id Based On Status Name */
                        $client_status_id = $this->parse->get_client_status_id_by_name('inactive');
                        /* Set Client Status - Inctive */
                        $this->client->set_client_status($contract->client, $client_status_id);
                    }
                }

                $sandler_payday = $this->rate->get_sandler_paying_day();
                $next_month_payday = $this->parse->get_next_month_paying_date($sandler_payday);
                /* Insert Sandler Debt For Legal Clients */
                $this->sandler->create_sandler_debt($invoice->value_din, $invoice->issue_date, $next_month_payday, $invoice->id);

                DB::commit();
                Session::flash('message','Profaktura broj '.$proinvoice->proinvoice_number.' je plaćena.'); 
            }else{
                Session::flash('message','Profaktura ne može biti plaćena jer nije izdata.');
            }

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška kod promene statusa profakture u plaćena!');
        }

        return back();
        
    }


    /**
     * Delete Proinvoice, Delete Invoice Associated With Proinvoice, Delete PDF File, Set Payment Associated With Proinvoice/Invoice Status Not Issued
     *
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract, Payment $payment, Proinvoice $proinvoice)
    {

        DB::beginTransaction();

        try {
            /* Proinovice Status Not Paid */
            if($proinvoice->is_paid != 1){
                /* Delete Invoice Associated With Proinvoice */
                $this->invoice->delete_invoice_from_proinvoice($proinvoice->id);
                /* Delete Proinvoice */
                $proinvoice->delete();
                /* Proinvoice Number (replaced /) */
                $proinvoice_number = str_replace("/","_",$proinvoice->proinvoice_number);
                /* Proinvoice PDF Filename */
                $filename = 'Profaktura_'.$proinvoice_number.'.pdf';
                /* Proinvoice PDF File Path */
                $pdf_file = $this->parse->get_pdf_invoice_path(false, $contract->client_id, $contract->id, $filename);
                 /* Delete Proinvoice PDF File If It Exists */ 
                if(Storage::disk('local')->exists($pdf_file)){                  
                    Storage::disk('local')->delete($pdf_file);
                }
                /* Set Status Not Issued For Payment Associated With Proinvoice/Invoice */
                $this->payment->set_payment_not_issued($payment);

                DB::commit();
                Session::flash('message','Profaktura je uspešno obrisana.');
            }else{
                Session::flash('message','Profaktura ne može biti obrisana jer je plaćena.');
            }

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Profaktura nije obrisana.');
        }

        return redirect('/payment/'.$contract->id.'/'.$payment->id);
    }





}
