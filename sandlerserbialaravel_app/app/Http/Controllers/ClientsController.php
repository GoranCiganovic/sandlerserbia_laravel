<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientStatus;
use App\CompanySize;
use App\Invoice;
use App\Proinvoice;
use App\Classes\Parse;
use Illuminate\Http\Request;
use Session;

class ClientsController extends Controller
{
    /**
     * Create a new Clients Controller instance.
     *
     * @return void
     */
    public function __construct(Client $client = null, ClientStatus $client_status = null, CompanySize $company_size = null, Invoice $invoice = null, Proinvoice $proinvoice = null, Parse $parse = null)
    {
        $this->client = $client;
        $this->client_status = $client_status;
        $this->company_size = $company_size;
        $this->invoice = $invoice;
        $this->proinvoice = $proinvoice;
        $this->parse = $parse;
    }

    /**
     * Show Client Profile based on legal status (Legal or Individual)
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    { 
        $clientID = $client->id;
        $legal_status = $client->legal_status_id;
        $contracts_array = $client->load('contract.contract_status');
        /* Contracts */
        $contracts = $contracts_array->contract;
        /* Presentation Proinovices/Invoices */
        $proinvoices = $this->proinvoice->get_clients_presentation_proinvoices($client->id);
        /* Presentation Invoices */
        $invoices = $this->invoice->get_clients_presentation_invoices($client->id);

        if($legal_status == 1){

            $legal = $client->legal;
            $client_status = $legal->client_status;

            return view('legals.show', compact('clientID','legal_status','legal','client_status', 'contracts', 'proinvoices', 'invoices'));

        }else if($legal_status == 2){

            $individual = $client->individual;
            $client_status = $individual->client_status;  

            return view('individuals.show', compact('clientID','legal_status','individual','client_status', 'contracts', 'proinvoices', 'invoices'));

        }else{
            return back();
        }
     
    }

    /**
     * Show the form for editing Client Profile based on legal status (Legal or Individual)
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $clientID = $client->id;
        $legal_status = $client->legal_status_id;

        if($legal_status == 1){

            $legal = $client->legal;
            $client_status = $legal->client_status;
            $company_size = $this->company_size->get_company_size_by_id($legal->company_size_id);
            $company_sizes = $this->company_size->get_company_sizes();

            return view('legals.edit', compact('clientID','legal_status','legal','client_status','company_size','company_sizes'));

        }else if($legal_status == 2){

            $individual = $client->individual;
            $client_status = $individual->client_status;  

            return view('individuals.edit', compact('clientID','legal_status','individual','client_status'));

        }else{
            return back();
        }
    }

    /**
     * Update Client Status.
     *
     * @param  \App\Client  $client_id
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function change_status(Client $client_id, $status)
    {
         /* Get Client (Legal or Individual) */
        $client = $this->client->get_client($client_id);

        /* Change Status If Not Active or Inactive Status*/
        if($client->client_status_id != 5 && $client->client_status_id != 6){
            /* Add Conversation Date Today*/
            $client->conversation_date = date('Y-m-d');
            $client->client_status_id = $status;
            /* If Status Accept Meeting Add Meeting Date Today */
            if($status == 3){
                $client->accept_meeting_date = date('Y-m-d');
            }
            $client->save(); 
        }

        Session::flash('message','Status je uspešno promenjen.');
        return back();
    }

    /**
     * Delete Client Profile if Client Status Uncontacted (with Legal or Individual profile) .
     *
     * @param \App\Client  $client
     * @param  string  $client_status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, $client_status)
    {
        if($client->legal_status_id == 1 && $client_status == 1){

            $client->legal()->delete();
            $client->delete();
        }

        if($client->legal_status_id == 2 && $client_status == 1){

            $client->individual()->delete();
            $client->delete();
        }
        Session::flash('message','Profil je uspešno obrisan.');
        return redirect('home');
    }

    /**
     * Display Clients (Home Page) from Input Search - Ajax
     *
     * @param \Illuminate\Http\Request $request
     * @param  string  $legal
     * @param  string  $sort
     * @return \Illuminate\Http\Response
     */
    public function search_all(Request $request, $legal, $sort)
    {
        $search = $request->input('search');
        $legal_filter = $request->route('legal');
        $sort_filter = $request->route('sort');

        $request['legal_filter'] = $legal_filter;
        $request['sort_filter'] = $sort_filter;

        $this->validate($request, [
            'search' => 'regex:/(^[0-9a-zA-Z ]+$)+/',
            'legal_filter' => 'numeric|digits_between:0,2',
            'sort_filter' => 'numeric|digits_between:0,4'
        ]); 

        $legal_status_in = $this->parse->getSortLegalStatuses($legal_filter);
        $order = $this->parse->getSortFilterArrayValue($sort_filter);
        $legal_column = $order['legal_column'];
        $individual_fcolumn = $order['individual_fcolumn'];
        $individual_lcolumn = $order['individual_lcolumn'];
        $order_by = $order['order_by'];
        $pagination = 10;// pagination
        
        /* Clients From Input Search */
        $clients = $this->client->search_input_clients_pagination($search, $legal_status_in, $legal_column, $individual_fcolumn, $individual_lcolumn, $order_by, $pagination);

        if ($request->ajax()) {
            return view('clients.search_ajax', compact('clients', 'search', 'legal_filter', 'sort_filter'));
        }else{
           return back();   
        }
       
    }

    /**
     * Display Clients (Home Page) by client status - Ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search_by_status(Request $request)
    {

        $this->validate($request, [
            'client_status' => 'required|numeric|digits_between:1,6',
            'local_search' => 'regex:/(^[0-9a-zA-Z ]+$)+/',
            'legal_filter' => 'filled|numeric|digits_between:1,2',
            'sort_filter' => 'filled|numeric|digits_between:1,4',
       ]);

        $client_status = $request->input('client_status');
        $legal_filter = $request->input('legal_filter');
        $sort_filter = $request->input('sort_filter');
        $local_search = $request->input('local_search');

        $legal_status_in = $this->parse->getSortLegalStatuses($legal_filter);//dodao
        $order = $this->parse->getSortFilterArrayValue($sort_filter);
        $legal_column = $order['legal_column'];//table column name
        $individual_fcolumn = $order['individual_fcolumn'];//table column name
        $individual_lcolumn = $order['individual_lcolumn'];//table column name
        $order_by = $order['order_by'];// sort order by
        $pagination = 10;// pagination

        /* Client Status Data */
        $status = $this->client_status->get_client_status_by_client_status_id($client_status);               
        /* Clients by Client Status */
        $clients = $this->client->search_clients_by_client_status_pagination($local_search, $client_status, $legal_status_in, $legal_column, $individual_fcolumn, $individual_lcolumn, $order_by, $pagination);

        if ($request->ajax()) {
            return view('clients.clients_ajax', compact('status', 'clients', 'legal_filter', 'client_status', 'sort_filter', 'local_search'));
        }else{
            return back();
        }
       
    }


}
