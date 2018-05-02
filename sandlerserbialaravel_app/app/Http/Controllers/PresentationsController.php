<?php

namespace App\Http\Controllers;

use App\Client;
use App\Contract;
use App\Rate;
use App\ExchangeRate;
use App\Invoice;
use App\Proinvoice;
use App\Sandler;
use App\Classes\Parse;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use Illuminate\Support\Facades\DB;
use Session;
use Exception;
use Storage;


class PresentationsController extends Controller
{
    /**
     * Request Except On Store
     *
     * @var array
     */
    protected $store_except = [
        '_token', 'submit', 'format_traffic_date', 'format_issue_date'
    ];

    /**
     * Request Except On Update
     *
     * @var array
     */
    protected $update_except = [
        '_token', 'submit', 'form_pdf_action', 'format_traffic_date', 'format_issue_date', 'form_issued_action', 'form_delete_action'
    ];

    /**
     * Create a new Presentations Controller instance.
     *
     * @return void
     */
    public function __construct(Client $client = null, Contract $contract = null, Rate $rate = null, ExchangeRate $exchange = null, Invoice $invoice = null, Proinvoice $proinvoice = null, Sandler $sandler = null, Parse $parse=null)
    {
        $this->client = $client;
        $this->contract = $contract;
        $this->rate = $rate;
        $this->exchange = $exchange;
        $this->invoice = $invoice;
        $this->proinvoice = $proinvoice;
        $this->sandler = $sandler;
        $this->parse = $parse;
    }

    /**
     * Show the form for creating a new Presentation (Proinvoice/Invoice)
     *
     * @param \App\Client $client
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client, $type)
    {
        /* Payment Type (Invoice/Proinvoice) */
        $type = $this->parse->get_payment_type($type); 
        if($type){
            /* Exchange Rate Euro */
            $euro = $this->exchange->get_current_exchange_euro();
            /* PDV Based On Legal Status */
            $pdv = $this->rate->get_pdv_percent_by_legal_status($client->legal_status_id);
            /* Prevent Double Submit */
            $current_time = $this->parse->generate_current_time_session_key('single_submit');

            return view('invoices.presentations.create', compact('client', 'euro', 'pdv', 'type', 'current_time'));

        }else{

            return back();
        }
    }


    /**
     * Show the form for creating a new Invoice From Proinvoice for Presentation
     *
     * @param \App\Client $client
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function invoice_from_proinvoice(Client $client, Proinvoice $proinvoice)
    {
        /* Stored Invoice Associeated With Stored Proinvoice for Presentation */
        $invoice = $this->invoice->get_invoice_by_proinvoice_id($proinvoice->id);
        return view('invoices.presentations.create_from_proinvoice', compact('client', 'proinvoice', 'invoice'));
    }


    /**
     * Store New Proinvoice ,Store Invoice Associated With Created Proinvoice for Presentation
     *
     * @param  \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store_proinvoice(InvoiceRequest $request, Client $client)
    {
        $rules = array_merge($request->rules(),['single_submit'=>'numeric|size:'.$request->session()->get('single_submit')]);
        $this->validate($request, $rules);

        DB::beginTransaction();

        try {
            /* Payment Type (Invoice/Proinvoice) */
            $type = $this->parse->get_payment_type('proinvoice');
            /* Next Number - Proinvoice Number And Serial Number (Legal or Individaul) */
            $proinvoice_number_arr = $this->parse->next_invoice_proinvoice_number($client->legal_status_id, $type);
            /* Insert Proinvoice (No Contract Id and Payment Id) */
            $proinvoice_id = Proinvoice::create(array_merge($request->except($this->store_except), [
                'serial_number' => $proinvoice_number_arr['serial_number'], 
                'proinvoice_number' => $proinvoice_number_arr['proinvoice_number'],
                'payment_id' => 0,
                'contract_id' => 0,
                'client_id' => $client->id    
            ]))->id;
            /* Insert Invoice Associated With Proinvoice (No Contract Id and Payment Id) */
            Invoice::create(array_merge($request->except($this->store_except), [
                'proinvoice_id' => $proinvoice_id,
                'payment_id' => 0,
                'contract_id' => 0,
                'client_id' => $client->id          
            ]));

            /* Remove Single Submit Session */
            $request->session()->forget('single_submit');

            DB::commit();
            Session::flash('message','Profaktura broj '.$proinvoice_number_arr['proinvoice_number'].' je kreirana.'); 

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Profaktura nije kreirana.');
        }

        return redirect('/client/'.$client->id);
    }

    /**
     * Store New Invoice for Presentation
     *
     * @param \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store_invoice(InvoiceRequest $request, Client $client)
    {
        $rules = array_merge($request->rules(),['single_submit'=>'numeric|size:'.$request->session()->get('single_submit')]);
        $this->validate($request, $rules);

        DB::beginTransaction();

        try {
            /* Payment Type (Invoice/Proinvoice) */
            $type = $this->parse->get_payment_type('invoice');
            /* Next Number - Invoice Number And Serial Number (Legal or Individaul) */
            $invoice_number_arr = $this->parse->next_invoice_proinvoice_number($client->legal_status_id, $type);
            /* Insert Invoice Associated With Proinvoice (No Contract Id and Payment Id) */
            Invoice::create(array_merge($request->except($this->store_except), [
                'serial_number' => $invoice_number_arr['serial_number'], 
                'invoice_number' => $invoice_number_arr['invoice_number'],
                'payment_id' => 0,
                'contract_id' => 0,
                'client_id' => $client->id   
            ]));

            /* Remove Single Submit Session */
            $request->session()->forget('single_submit');

            DB::commit();
            Session::flash('message','Faktura broj '.$invoice_number_arr['invoice_number'].' je kreirana.'); 

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Faktura nije kreirana.');
        }

        return redirect('/client/'.$client->id);
    }
    

    /**
     * Show the form for editing Invoice or Proinvoice for Presentation
     *
     * @param int $client_id
     * @param strig $invoice_type
     * @param int $type_id
     * @return \Illuminate\Http\Response
     */
    public function edit($client_id, $invoice_type, $type_id)
    {   
        /* Type (Invoice or Proinvoice) */
        $type = $this->parse->get_payment_type($invoice_type);
        if($type){
            $client = $this->client->get_client_by_client_id($client_id);
            $invoice = DB::table($type['table'])->where('id', $type_id)->first();
            if($invoice){
               return view('invoices.presentations.edit', compact('type', 'client', 'invoice')); 
            }  
        }
        abort(400);
    }

    /**
     * Update Proinvoice for Presentation and Invoice Associated With Updated Proinvoice
     *
     * @param \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Client $client
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function update_proinvoice(InvoiceRequest $request, Client $client, Proinvoice $proinvoice)
    {
        $this->validate($request, $request->rules());

        DB::beginTransaction();

        try {
            /* Update Proinvoice */
            Proinvoice::where('id', $proinvoice->id)->update($request->except($this->update_except));
            /* Update Invoice Associated With Proinvoice */
            Invoice::where('proinvoice_id', $proinvoice->id)->update($request->except($this->update_except));

            DB::commit();
            Session::flash('message','Profaktura broj '.$proinvoice->proinvoice_number.' je izmenjena.'); 

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Profaktura nije izmenjena.');
        }

        return back();
    }

    /**
     * Update Invoice for Presentation
     *
     * @param \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Client $client
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update_invoice(InvoiceRequest $request, Client $client, Invoice $invoice)
    {
        $this->validate($request, $request->rules());

        DB::beginTransaction();

        try {
            /* Update Invoice */
            $invoice->update($request->except($this->update_except));

            DB::commit();
            Session::flash('message','Faktura broj '.$invoice->invoice_number.' je izmenjena.'); 

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Faktura nije izmenjena.');
        }

        return back();
    }


    /**
     * Delete Proinvoice, Invoice based on Proinvoice, delete pdf files for Presentation
     *
     * @param \App\Client $client
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy_proinvoice(Client $client, Proinvoice $proinvoice)
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
                $pdf_file = $this->parse->get_pdf_invoice_path(false, $client->id, 0, $filename);
                /* Delete Proinvoice PDF File If It Exists */ 
                if(Storage::disk('local')->exists($pdf_file)){                     
                    Storage::disk('local')->delete($pdf_file);
                }

                DB::commit();
                Session::flash('message','Profaktura je uspešno obrisana.');
            }else{
                Session::flash('message','Profaktura ne može biti obrisana jer je plaćena.');
            }

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Profaktura nije obrisana.');
        }

       return redirect('/client/'.$client->id);
    }

    /**
     * Delete Invoice for Presentation
     *
     * @param \App\Client $client
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy_invoice(Client $client, Invoice $invoice)
    {
        DB::beginTransaction();

        try {
            /* Inovice Status Not Issued and No Proinvoice Associated With */
            if($invoice->is_issued != 1 && $invoice->proinvoice_id == ''){
                /* Delete Invoice */
                $invoice->delete();
                /* Invoice Number (replaced /) */
                $invoice_number = str_replace("/","_",$invoice->invoice_number);
                /* Invoice PDF Filename */
                $filename = 'Faktura_'.$invoice_number.'.pdf';
                /* Invoice PDF File Path */
                $pdf_file = $this->parse->get_pdf_invoice_path(false, $client->id, 0, $filename);
                 /* Delete Invoice PDF File If It Exists */ 
                if(Storage::disk('local')->exists($pdf_file)){                  
                    Storage::disk('local')->delete($pdf_file);
                }

                DB::commit();
                Session::flash('message','Faktura je uspešno obrisana.');
            }else{
                Session::flash('message','Faktura ne može biti obrisana jer je izdata.');
                return back();
            }

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška! Faktura nije obrisana.');
        }

       return redirect('/client/'.$client->id);
    }

    /**
     * Issued Proinvoice for Presentation (Set Status to Issued)
     *
     * @param \App\Client $client
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function issued_proinvoice(Client $client, Proinvoice $proinvoice)
    {
        $issued = $this->proinvoice->set_proinvoice_issued($proinvoice);
        if($issued){
             Session::flash('message','Profaktura broj '.$proinvoice->proinvoice_number.' je izdata.'); 
             return redirect('/client/'.$client->id);
        }else{
            Session::flash('message','Greška kod promene statusa profakture u izdata!');
            return back();
        }
        
    }

    /**
     * Issued Invoice (Change Status to Issued and Paid Status, Insert Next Invoice Number and Create Sandler Debt)
     *
     * @param \App\Client $client
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function issued_invoice(Client $client, Invoice $invoice)
    {

        DB::beginTransaction();

        try {
            /* Inovoice Without Number (Inserted When Proinvoice Associated With Was Stored)  */
            if(!$invoice->invoice_number && $invoice->proinvoice_id != ''){
                 /* Type (Invoice or Proinvoice) */
                $type = $this->parse->get_payment_type('invoice');
                /* Next Number - Invoice Number And Serial Number (Legal or Individaul) */
                $invoice_number_arr = $this->parse->next_invoice_proinvoice_number($client->legal_status_id, $type);
                $serial_number = $invoice_number_arr['serial_number'];
                $invoice_number = $invoice_number_arr['invoice_number'];
                 /* Set Issued Status, Paid Status, Serial Number, Invoice Number */
                $this->invoice->set_invoice_from_proinvoice_issued($invoice, $serial_number, $invoice_number);

            }else{
                /* Invoice Without Proinvoice */
                $invoice_number = $invoice->invoice_number;
                /* Set Issued Status */
                $this->invoice->set_invoice_issued($invoice);

                $sandler_payday = $this->rate->get_sandler_paying_day();
                $next_month_payday = $this->parse->get_next_month_paying_date($sandler_payday);
                /* Insert Sandler Debt For Legal Clients (Already Inserted For Invoices Associated With Proinvoice) */
                $this->sandler->create_sandler_debt($invoice->value_din, $invoice->issue_date, $next_month_payday, $invoice->id);
                /* Get Client (Lelgal/Individual) */
                $client_collection = $this->client->get_client($client);
                /* Set Client's Closing Date */
                if(!$client_collection->closing_date){
                     $this->client->set_closing_date($client_collection);
                }
            }
            /* Change Client Status (Active/Inactive) */
            $this->set_status_after_paying($client);

            DB::commit();
            Session::flash('message','Faktura broj '.$invoice_number.' je izdata.'); 
            return redirect('/client/'.$client->id);

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška kod promene statusa fakture u izdata!');
        }

        return back();
        
    }

    /**
     * Display Invoice or Provinvoice for Presentation
     *
     * @param int $client_id
     * @param strig $invoice_type
     * @param int $type_id
     * @return \Illuminate\Http\Response
     */
    public function show($client_id, $invoice_type, $type_id)
    {   
        /* Type (Invoice or Proinvoice) */
        $type = $this->parse->get_payment_type($invoice_type);
        if($type){
            $client = $this->client->get_client_by_client_id($client_id);
            $invoice = DB::table($type['table'])->where('id', $type_id)->first();
            if($invoice){
               return view('invoices.presentations.show', compact('type', 'client', 'invoice')); 
            }  
        }
        abort(400);
    }

    /**
     * Paid Proinvoice (Set Proinvoice Status Paid, Store Proinvoice Paid Date, Set Invoice Associated With Proinvoice Status Paid ,Store Invoice Associated With Proinvoice Paid Date, Update Client Status After Paying Invoice (Actvite or Inactive), Create Sandler Debt for Legal Clients)
     *      
     * @param \App\Client $client
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function paid_proinvoice(Client $client, Proinvoice $proinvoice)
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
                /* Set Invoice Associated With Proinvoce Paid Status, Paid Date - Today,PDV Paying Date */
                $invoice =  $this->invoice->get_invoice_by_proinvoice_id($proinvoice->id);
                $this->invoice->set_invoice_paid($invoice, $pdv_paying_date);
                /* Change Client Status (Active/Inactive) */
                $this->set_status_after_paying($client);

                $sandler_payday = $this->rate->get_sandler_paying_day();
                $next_month_payday = $this->parse->get_next_month_paying_date($sandler_payday);
                /* Insert Sandler Debt For Legal Clients */
                $this->sandler->create_sandler_debt($invoice->value_din, $invoice->issue_date, $next_month_payday, $invoice->id);
                /* Get Client (Lelgal/Individual) */
                $client_collection = $this->client->get_client($client);
                /* Set Client's Closing Date */
                if(!$client_collection->closing_date){
                     $this->client->set_closing_date($client_collection);
                }

                DB::commit();
                Session::flash('message','Profaktura broj '.$proinvoice->proinvoice_number.' je plaćena.'); 
                return redirect('/client/'.$client->id);

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
     * Paid Invoice (Set Invoice Status to Paid, Store Invoice Paid Date, Update Client Status (if there are no client contracts In Progress),)
     *
     * @param \App\Client $client
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function paid_invoice(Client $client, Invoice $invoice)
    {
        DB::beginTransaction();

        try {
            /* Issued Invoice */
            if($invoice->is_issued == 1){

                /* PDV Paying Day */
                $pdv_paying_day = $this->rate->get_pdv_paying_day();
                /* Next Month PDV Paying Date */
                $pdv_paying_date = $this->parse->get_next_month_paying_date($pdv_paying_day);
                /* Set Invoice Paid Status, Paid Date - Today, PDV Paying Date */
                $this->invoice->set_invoice_paid($invoice, $pdv_paying_date);
                /* Change Client Status (Active/Inactive) */
                $this->set_status_after_paying($client);

                DB::commit();
                Session::flash('message','Faktura broj '.$invoice->invoice_number.' je plaćena.'); 
            }else{
                Session::flash('message','Faktura ne može biti plaćena jer nije izdata.');
                return back();
            }

        } catch (Exception $e) {
            
            DB::rollback();
            Session::flash('message','Greška kod promene statusa fakture u plaćena!');
        }

        return back();
        
    }


    /**
     * Set Client Status After Paying Invoice for Presentation (Active or Inactive)
     *
     * @param  \App\Client $client
     * @return bool
     */
     public function set_status_after_paying(Client $client){
        /* Number Of Client's In Progress Contracts */                 
        $in_progress_contracts = $this->contract->count_clients_in_progress_contracts($client->id);
        /* Presentation Invoices Associated With Proinvoices (No Contract Associated WIth) Paid And Not Issued */
        $in_progress_invoices_proinvoices = $this->invoice->count_clients_presentation_invoices_paid_not_issued($client->id);
        /* Presentations Invoices (No Contract Associated WIth) Not Paid And Issued */
        $in_progress_invoices = $this->invoice->count_clients_presentation_invoices_issued_not_paid($client->id);
        /* Change Status for Contracts With No In Progress Status */                           
        if(!$in_progress_contracts){      
            if($in_progress_invoices || $in_progress_invoices_proinvoices){
                /* Get Client Status Id Based On Status Name Active */
                $client_status_id = $this->parse->get_client_status_id_by_name('active');
            }else{
                /* Get Client Status Id Based On Status Name Inactive */
                $client_status_id = $this->parse->get_client_status_id_by_name('inactive'); 
            }
            /* Set Client Status */ 
            $this->client->set_client_status($client, $client_status_id); 
        } 
         
     }





}
