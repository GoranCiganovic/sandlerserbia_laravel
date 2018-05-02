<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proinvoice extends Model
{
   	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'serial_number', 'proinvoice_number', 'value_euro', 'exchange_euro','value_din','pdv', 'pdv_din', 'value_din_tax', 'issue_date', 'paid_date', 'traffic_date', 'pdv_paid_date', 'description', 'note', 'is_paid', 'is_issued', 'payment_id', 'contract_id', 'client_id' 
    ];

   	/**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns Number Of Created Proinvoices Not Issued, Not Paid  
     *
     * @return int
     */
    public function count_proinvoices_not_issued_not_paid(){   
        return  Proinvoice::where('is_issued',0)->where('is_paid',0)->count();
    }
    /**
     * Returns Created Proinvoices Not Issued, Not Paid  With Pagination
     *
     * @return \App\Proinvoice
     */
    public function get_proinvoices_not_issued_not_paid_pagination($pagination = 10){   
        return  Proinvoice::where('is_issued',0)->where('is_paid',0)->paginate($pagination);
    }

    /**
     * Returns Number Of Proinvoices-Advance Issued And Not Paid 
     *
     * @return int     
     */
    public function count_proinvoices_issued_not_paid(){   
      return Proinvoice::where('is_issued',1)->where('is_paid', 0)->count();
    }

    /**
     * Returns Issued Proinvoices Not Paid  With Pagination
     *
     * @return \App\Proinvoice
     */
    public function get_proinvoices_issued_not_paid_pagination($pagination = 10){   
        return  Proinvoice::where('is_issued',1)->where('is_paid',0)->paginate($pagination);
    }


    /**
     * Returns Proinvoice By Payment Id
     *
     * @param  int $payment_id
     * @return  \App\Proinvoice
     */
    public function get_proinvoice_by_payment_id($payment_id){
        return  Proinvoice::where('payment_id', $payment_id)->first();
    }

    /**
     * Returns Client's Presentation Proinvoices
     *
     * @param  int $client_id
     * @return  \App\Proinvoice
     */
    public function get_clients_presentation_proinvoices($client_id){
        return  Proinvoice::select( 'proinvoices.id as id', 
                                   'invoices.id as invoice_id', 
                                   'invoices.proinvoice_id as proinvoice_id',
                                   'proinvoices.proinvoice_number as proinvoice_number',
                                   'invoices.invoice_number as invoice_number',
                                   'proinvoices.is_issued as is_issued',
                                   'proinvoices.is_paid as is_paid',
                                   'proinvoices.contract_id as contract_id',
                                   'proinvoices.payment_id as payment_id' )
                            ->join('invoices', 'invoices.proinvoice_id', '=', 'proinvoices.id')
                            ->where('proinvoices.contract_id', 0)
                            ->where('proinvoices.client_id', $client_id)
                            ->get();
    }

    /**
     * Set Pronvoice Status Issued  
     *
     * @param  \App\Pronvoice $proinvoice
     * @return bool     
     */
    public function set_proinvoice_issued(Proinvoice $proinvoice){   
        return  $proinvoice->update(['is_issued'=> 1]);
    }

    /**
     * Set Pronvoice Status Paid  
     *
     * @param  \App\Pronvoice $proinvoice
     * @param  string $pdv_paying_date
     * @return bool     
     */
    public function set_proinvoice_paid(Proinvoice $proinvoice, $pdv_paying_date){   
        return  $proinvoice->update(['is_paid' => 1, 
                                     'paid_date' => date('Y-m-d'), 
                                     'pdv_paid_date' => $pdv_paying_date]);

    }
}
