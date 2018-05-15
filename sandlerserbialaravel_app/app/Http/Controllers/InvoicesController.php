<?php

namespace App\Http\Controllers;

use App\Classes\Parse;
use App\Client;
use App\Contract;
use App\ExchangeRate;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use App\Payment;
use App\Proinvoice;
use App\Rate;
use App\Sandler;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Storage;

class InvoicesController extends Controller
{

    /**
     * Create a new Invoices Controller instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice = null, Rate $rate = null, ExchangeRate $exchange = null, Client $client = null, Contract $contract = null, Payment $payment = null, Sandler $sandler = null, Parse $parse = null)
    {
        $this->invoice = $invoice;
        $this->rate = $rate;
        $this->exchange = $exchange;
        $this->client = $client;
        $this->contract = $contract;
        $this->payment = $payment;
        $this->sandler = $sandler;
        $this->parse = $parse;
    }

    /**
     * Display Invoces from Proinvoices - Ajax (Home-Page) (Invoice has Proinvoice with Paid Status and Not Issued Status)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function from_proinvoices(Request $request)
    {
        $title = "Fakture koje traba izdati po plaćenim profakturama";
        $invoices = $this->invoice->get_invoices_from_paid_proinvoices($pagination = 10);
        if ($request->ajax()) {
            return view('invoices.ajax_invoices.from_proinvoice', compact('invoices', 'title'));
        } else {
            return back();
        }
    }

    /**
     * Display Invoces for Issuing Today - Ajax (Home-Page) (Payment Paying Date on Today, Not Issued, Not Paid, Is Not Advance and Contract Status In Progress)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function issue_today(Request $request)
    {
        $title = "Rate za koje je potrebno izdati fakturu";
        $invoices = $this->payment->get_payments_non_advance_issue_today_pagination($pagination = 10);
        if ($request->ajax()) {
            return view('invoices.ajax_invoices.issue_today', compact('invoices', 'title'));
        } else {
            return back();
        }
    }

    /**
     * Display Created Invoices - Confirm Issued Status - Ajax (Home-Page) (Invoice Not Paid, Not Issued and Proinvoice  Null)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function confirm_issued(Request $request)
    {
        $title = "Fakture za koje je potrebno potvrditi da su izdate";
        $invoices = $this->invoice->get_invoices_not_issued_not_paid_pagination($pagination = 10);
        if ($request->ajax()) {
            return view('invoices.ajax_invoices.confirm_issued', compact('invoices', 'title'));
        } else {
            return back();
        }
    }

    /**
     * Display Issued Invoices - Confirm Paid Status- Ajax (Home-Page) (Invoice Is Issued, Not Paid and Proinvoice  Null)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function confirm_paid(Request $request)
    {
        $title = "Izdate fakture za koje je potrebno potvrditi da su plaćene";
        $invoices = $this->invoice->get_invoices_issued_not_paid_pagination($pagination = 10);
        if ($request->ajax()) {
            return view('invoices.ajax_invoices.confirm_paid', compact('invoices', 'title'));
        } else {
            return back();
        }
    }

    /**
     * Display All paid Invoices - Ajax (Home-Page)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function all_paid(Request $request)
    {
        $title = "Plaćene fakture";
        $invoices = $this->invoice->get_invoices_paid($pagination = 10);
        if ($request->ajax()) {
            return view('invoices.ajax_invoices.all_paid', compact('invoices', 'title'));
        } else {
            return back();
        }
    }

    /**
     * Show the form for creating a new Invoice or Proinvoice (Associated With Contract Payment)
     *
     * @param  string $invoice_type
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function create($invoice_type, Contract $contract, Payment $payment)
    {
        /* Type (Invoice or Proinvoice) */
        $type = $this->parse->get_payment_type($invoice_type);
        if ($type) {
            /* Invoice/Proinvoice Associated With Payment */
            $payment_type = DB::table($type['table'])->where('payment_id', '=', $payment->id)->first();
            if (!$payment_type) {
                /* PDV Based On Legal Status */
                $pdv = $this->rate->get_pdv_percent_by_legal_status($contract->legal_status_id);
                /* Exchange Rate Euro */
                $euro = $this->exchange->get_current_exchange_euro();
                /* Value RSD */
                $value_din = round($payment->value_euro * $euro, 2);
                /* PDV RSD */
                $pdv_din = round(($value_din * $pdv) / 100, 2);
                /* Value With PDV RSD*/
                $value_din_tax = round($value_din + $pdv_din, 2);
                /* Prevent Double Submit */
                $current_time = $this->parse->generate_current_time_session_key('single_submit');

                return view('invoices.create', compact('type', 'contract', 'payment', 'euro', 'pdv', 'value_din', 'pdv_din', 'value_din_tax', 'current_time'));
            } else {
                return back();
            }
        }
        abort(400);
    }

    /**
     * Show the form for creating a new Invoice from Proinvoice
     *
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Proinvoice $proinvoice
     * @return \Illuminate\Http\Response
     */
    public function create_from_proinvoice(Contract $contract, Payment $payment, Proinvoice $proinvoice)
    {
        $invoice = $this->invoice->get_invoice_by_proinvoice_id($proinvoice->id);
        return view('invoices.create_from_proinvoice', compact('contract', 'payment', 'proinvoice', 'invoice'));
    }

    /**
     * Store New Invoice and Set Payment Status Issued
     *
     * @param  \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request, Contract $contract, Payment $payment)
    {
        /* Contract Status In Progress */
        if ($contract->contract_status_id == 2) {
            $rules = array_merge($request->rules(), ['single_submit' => 'numeric|size:' . $request->session()->get('single_submit')]);
            $this->validate($request, $rules);

            DB::beginTransaction();

            try {
                /* Type (Invoice or Proinvoice) */
                $type = $this->parse->get_payment_type('invoice');
                /* Next Number - Invoice Number And Serial Number (Legal or Individaul) */
                $invoice_number_arr = $this->parse->next_invoice_proinvoice_number($contract->legal_status_id, $type);
                /* Insert Invoice */
                Invoice::create(array_merge($request->except($request->store_except()), [
                    'value_euro' => $payment->value_euro,
                    'serial_number' => $invoice_number_arr['serial_number'],
                    'invoice_number' => $invoice_number_arr['invoice_number'],
                    'payment_id' => $payment->id,
                    'contract_id' => $contract->id,
                    'client_id' => $contract->client_id,
                ]));

                /* Remove Single Submit Session */
                $request->session()->forget('single_submit');

                DB::commit();
                Session::flash('message', 'Faktura broj ' . $invoice_number_arr['invoice_number'] . ' je kreirana.');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash('message', 'Greška! Faktura nije kreirana.');
            }
        } else {
            Session::flash('message', 'Faktura nije kreirana jer je Ugovor ' . $contract->contract_status->name . '.');
        }

        return redirect('/payment/' . $contract->id . '/' . $payment->id);
    }

    /**
     * Show the form for editing Invoice or Proinvoice
     *
     * @param  string $invoice_type
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param int $type_id
     * @return \Illuminate\Http\Response
     */
    public function edit($invoice_type, Contract $contract, Payment $payment, $type_id)
    {
        /* Type (Invoice or Proinvoice) */
        $type = $this->parse->get_payment_type($invoice_type);
        if ($type) {
            $invoice = DB::table($type['table'])->where('id', $type_id)->first();
            if ($invoice) {
                return view('invoices.edit', compact('type', 'contract', 'payment', 'invoice'));
            }
        }
        abort(400);
    }

    /**
     * Update Invoice
     *
     * @param \App\Http\Requests\InvoiceRequest  $request
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, Contract $contract, Payment $payment, Invoice $invoice)
    {
        $this->validate($request, $request->rules());

        DB::beginTransaction();

        try {
            /* Update Invoice */
            $invoice->update($request->except($request->update_except()));

            DB::commit();
            Session::flash('message', 'Faktura je izmenjena.');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('message', 'Greška! Faktura nije izmenjena.');
        }

        return back();
    }

    /**
     * Issued Invoice (Set Issued Status and Paid Status, Insert Next Invoice Number and Create Sandler Debt)
     *
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function issued(Contract $contract, Payment $payment, Invoice $invoice)
    {

        DB::beginTransaction();

        try {
            /* Inovoice Without Number (Inserted When Proinvoice Associated With Was Stored)  */
            if (!$invoice->invoice_number && $invoice->proinvoice_id != '') {
                /* Type (Invoice or Proinvoice) */
                $type = $this->parse->get_payment_type('invoice');
                /* Next Number - Invoice Number And Serial Number (Legal or Individaul) */
                $invoice_number_arr = $this->parse->next_invoice_proinvoice_number($contract->legal_status_id, $type);
                $serial_number = $invoice_number_arr['serial_number'];
                $invoice_number = $invoice_number_arr['invoice_number'];
                /* Set Issued Status, Paid Status, Serial Number, Invoice Number */
                $this->invoice->set_invoice_from_proinvoice_issued($invoice, $serial_number, $invoice_number);
            } else {
                /* Invoice Without Proinvoice */
                $invoice_number = $invoice->invoice_number;
                /* Set Issued Status */
                $this->invoice->set_invoice_issued($invoice);
                /* Set Status Issued For Payment Associated With Invoice */
                $this->payment->set_payment_issued($payment);

                if ($contract->legal_status_id == 1) {
                    $sandler_payday = $this->rate->get_sandler_paying_day();
                    $next_month_payday = $this->parse->get_next_month_paying_date($sandler_payday);
                    /* Insert Sandler Debt For Legals (Already Inserted For Invoices Associated With Proinvoice) */
                    $this->sandler->create_sandler_debt($invoice->value_din, $invoice->issue_date, $next_month_payday, $invoice->id);
                }
            }

            DB::commit();
            Session::flash('message', 'Faktura broj ' . $invoice_number . ' je izdata.');
            return redirect('/payment/' . $contract->id . '/' . $payment->id);
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('message', 'Greška kod promene statusa fakture u izdata!');
        }

        return back();
    }

    /**
     * Paid Invoice (Set Invoice Paid Status, Store Invoice Paid Date, Set Payment Paid Status, Update Contract Rest and Paid, Update Client Status (if there are no client contracts In Progress),)
     *
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function paid(Contract $contract, Payment $payment, Invoice $invoice)
    {
        DB::beginTransaction();

        try {
            /* Issued Invoice */
            if ($invoice->is_issued == '1') {
                /* PDV Paying Day */
                $pdv_paying_day = $this->rate->get_pdv_paying_day();
                /* Next Month PDV Paying Date */
                $pdv_paying_date = $this->parse->get_next_month_paying_date($pdv_paying_day);
                /* Set Invoice Paid Status, Paid Date - Today, PDV Paying Date */
                $this->invoice->set_invoice_paid($invoice, $pdv_paying_date);
                /* Set Payment Associated With Invoice Paid Status  */
                $this->payment->set_payment_paid($payment);
                /* Update Contract Paid and Rest Based On Invoice Value */
                $paid = $contract->paid + $invoice->value_euro;
                $rest = $contract->rest - $invoice->value_euro;
                $this->contract->update_contract_paid_and_rest($contract, $paid, $rest);
                /* Contract Rest For Payment */
                if ($rest == '0') {
                    /* Get Contract Status Id Based On Status Name */
                    $contract_status_id = $this->parse->get_contract_status_id('finished');
                    /* Set Contract Status Finished */
                    $this->contract->set_contract_status($contract, $contract_status_id);
                    /* Number Of Client's In Progress Contracts */
                    $in_progress = $this->contract->count_clients_in_progress_contracts($contract->client_id);
                    /* Set Client (Legal/Individual) Status Inactive */
                    if ($in_progress == 0) {
                        /* Get Client Status Id Based On Status Name */
                        $client_status_id = $this->parse->get_client_status_id_by_name('inactive');
                        /* Set Client Status - Inctive */
                        $this->client->set_client_status($contract->client, $client_status_id);
                    }
                }

                DB::commit();
                Session::flash('message', 'Faktura broj ' . $invoice->invoice_number . ' je plaćena.');
            } else {
                Session::flash('message', 'Faktura ne može biti plaćena jer nije izdata.');
                return back();
            }
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('message', 'Greška kod promene statusa fakture u plaćena!');
        }

        return back();
    }

    /**
     * Delete Invoice, Delete PDF File, Update Payment Status Not Issued
     *
     * @param \App\Contract $contract
     * @param \App\Payment $payment
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract, Payment $payment, Invoice $invoice)
    {
        DB::beginTransaction();

        try {
            /* Inovice Status Not Issued and No Proinvoice Associated With */
            if ($invoice->is_issued != 1 && $invoice->proinvoice_id == '') {
                /* Delete Invoice */
                $invoice->delete();
                /* Invoice Number (replaced /) */
                $invoice_number = str_replace("/", "_", $invoice->invoice_number);
                /* Invoice PDF Filename */
                $filename = 'Faktura_' . $invoice_number . '.pdf';
                /* Invoice PDF File Path */
                $pdf_file = $this->parse->get_pdf_invoice_path(false, $contract->client_id, $contract->id, $filename);
                /* Delete Invoice PDF File If It Exists */
                if (Storage::disk('local')->exists($pdf_file)) {
                    Storage::disk('local')->delete($pdf_file);
                }
                /* Set Status Not Issued For Payment Associated With Invoice */
                $this->payment->set_payment_not_issued($payment);

                DB::commit();
                Session::flash('message', 'Faktura je uspešno obrisana.');
            } else {
                Session::flash('message', 'Faktura ne može biti obrisana jer je izdata.');
                return back();
            }
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('message', 'Greška! Faktura nije obrisana.');
        }

        return redirect('/payment/' . $contract->id . '/' . $payment->id);
    }

    /**
     * Display current PDV Debt
     *
     * @return \Illuminate\Http\Response
     */
    public function pdv_debt()
    {
        /* Previous Month Name */
        $previous_month = $this->parse->get_previous_month_name();
        /* First And Last Day Of The Previous Month  */
        $from_to_days = $this->parse->get_first_and_last_day_previous_month();
        /* Invoices Paid Last Month */
        $invoices = $this->invoice->count_last_month_paid_invoices($from_to_days['from'], $from_to_days['to']);
        /* PDV Percent*/
        $pdv_percent = $this->rate->get_pdv_percent();
        /* PDV Paying Date */
        $pdv_paying_day = $this->rate->get_pdv_paying_day();
        /* Current Date */
        $now = Carbon::now();
        /* Total PDV (Paid Invoices) RSD Value Issued Last Month */
        $pdv_debt = $this->invoice->get_last_month_pdv_debt($from_to_days['from'], $from_to_days['to']);

        return view('invoices.pdv_debt', compact('previous_month', 'invoices', 'pdv_debt', 'pdv_percent', 'pdv_paying_day', 'now'));
    }
}
