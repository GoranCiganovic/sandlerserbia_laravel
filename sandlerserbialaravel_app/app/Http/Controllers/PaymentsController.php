<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Invoice;
use App\Proinvoice;
use App\Classes\Parse;
use App\Contract;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentsController extends Controller
{

    /**
     * Create a new Payments Controller instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice = null, Proinvoice $proinvoice = null, Parse $parse = null)
    {
        $this->invoice = $invoice;
        $this->proinvoice = $proinvoice;
        $this->parse = $parse;
    }

    /**
     * Display All Payments by Contract (If Contract Status Is Unsigned View Update Payment Or If Contract Status Is Singed View Proinvoices/Invoices) 
     * 
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function index(Contract $contract)
    {
        $payments = $contract->payment_paginate($contract,$pagination = 10);
        if($contract->contract_status_id == 1){
            return view('payments.payments_unsigned_contract', compact('contract', 'payments'));
        }else{
            return view('payments.payments_signed_contract', compact('contract', 'payments'));
        }

    }


    /**
     * Display Single Payment by Contract (Invoice/Proinvoice). 
     * 
     * @param  \App\Contract  $contract
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */  
    public function show(Contract $contract, Payment $payment)
    {
        $invoice = $this->invoice->get_invoice_by_payment_id($payment->id);
        $proinvoice = $this->proinvoice->get_proinvoice_by_payment_id($payment->id);
        $payment_status = $this->get_payment_status($payment, $invoice);


        return view('payments.show_payment', compact('contract', 'payment', 'invoice', 'proinvoice', 'payment_status'));
    }


    /**
     * Show the form for editing Payment
     *
     * @param  \App\Contract  $contract
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract, Payment $payment)
    {
        return view('payments.edit_payment', compact('contract', 'payment'));
    }


    /**
     * Update Payment 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $this->validate($request, [
            'value_euro' => 'required|numeric|digits_between:0,10|min:0',
            'format_pay_date' => 'required|date_format:"d.m.Y."',
            'pay_date' => 'required|date_format:"Y-m-d"',
            'pay_date_desc' => 'required|max:255'
        ]);

        $payment->update($request->except('_token','format_pay_date'));

        $request->session()->flash('message', 'Rata je uspešno izmenjena.');

        return back();
    }



    /**
     * Returns Payment Status Name 
     *
     * @param  \App\Payment  $payment
     * @param  \App\Invoice  $invoice
     * @return  string
     */
    public function get_payment_status($payment, $invoice)
    {
        $status = '';
        if($invoice){
            if($payment->is_issued == 0 && $payment->is_paid == 0){
                $status = '<span class="text-white">Kreirana</span>';
            }else if($payment->is_issued == 1 && $payment->is_paid == 0){
                $status = '<span class="text-info">Izdata</span>';
            }else if($payment->is_paid == 1){
                $status = '<span class="text-success">Plaćena</span>';
            }else{

            }
       }else{
            $distance = $this->get_payment_distance($payment);
            if($distance == 0){
                $status = '<span class="text-info">Izdati na današnji dan!</span>';
            }else if($distance == 1){
                $status = '<span class="text-primary">Izdati na sutrašnji dan.</span>';
            }else if($distance > 1){
                $status = '<span class="text-primary">Broj dana do izdavanja: '.$distance.'</span>';
            }else if($distance < -1){
                $status = '<span class="text-danger">Trebalo je izdati juče!</span>';
            }else if($distance < -1){
                $status = '<span class="text-danger">Trebalo je izdati pre '.$distance.' dana!</span>';
            }
       }

        return $status;
    }

    /**
     * Returns Number Of Days From Today To The Paying Day 
     *
     * @param  \App\Payment  $payment
     * @return  int
     */
    public function get_payment_distance(Payment $payment)
    {
        $payday = Carbon::parse($payment->pay_date);// Pay Day Date
        $today = Carbon::today();// Today Date
        if($payday >= $today){
            $length = $payday->diffInDays($today);
        }else{
            $length = -$payday->diffInDays($today);
        }
        return $length;
    }
   
}
