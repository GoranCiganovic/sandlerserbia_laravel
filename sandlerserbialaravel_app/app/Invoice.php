<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'serial_number', 'invoice_number', 'value_euro', 'exchange_euro','value_din','pdv', 'pdv_din', 'value_din_tax', 'issue_date', 'paid_date', 'traffic_date', 'pdv_paid_date', 'description', 'note', 'is_paid', 'is_issued', 'proinvoice_id', 'payment_id', 'contract_id', 'client_id' 
    ];

    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Sandler that owns the Invoice.
     */
    public function sandler()
    {
        return $this->hasOne('App\Sandler', 'invoice_id');
    }


    /**
     * Returns Invoice By Payment Id
     *
     * @param  int $payment_id
     * @return  \App\Invoice
     */
    public function get_invoice_by_payment_id($payment_id){
        return  Invoice::where('payment_id', $payment_id)->first();
    }

    /**
     * Returns Invoice By Proinvoice Id
     *
     * @param  int $proinvoice_id
     * @return  \App\Invoice
     */
    public function get_invoice_by_proinvoice_id($proinvoice_id){
        return  Invoice::where('proinvoice_id', $proinvoice_id)->first();
    }



    /**
     * Returns Number Of Paid, Not Issued Invoices Associated With Paid Proinvoices-Advance 
     *
     * @return int     
     */
    public function count_invoices_from_paid_proinvoices(){   
      return  Invoice::join('proinvoices', 'proinvoices.id', '=', 'invoices.proinvoice_id')
                    ->where('proinvoices.is_issued',1)
                    ->where('proinvoices.is_paid',1)
                    ->whereNotNull('invoices.proinvoice_id')
                    ->where('invoices.is_issued',0)
                    ->where('invoices.is_paid',1)
                    ->count();
    }
    /**
     * Returns Paid, Not Issued Invoices Associated With Paid Proinvoices-Advance 
     *
     * @return \App\Invoice   
     */
    public function get_invoices_from_paid_proinvoices($pagination = 10){   
      return  Invoice::join('proinvoices', 'proinvoices.id', '=', 'invoices.proinvoice_id')
                    ->where('proinvoices.is_issued',1)
                    ->where('proinvoices.is_paid',1)
                    ->whereNotNull('invoices.proinvoice_id')
                    ->where('invoices.is_issued',0)
                    ->where('invoices.is_paid',1)
                    ->paginate($pagination);
    }



    /**
     * Returns Number Of Created Invoices (No Proinvoice Associated With) Not Issued, Not Paid  
     *
     * @return int
     */
    public function count_invoices_not_issued_not_paid(){   
        return  Invoice::where('is_issued',0)->where('is_paid',0)->whereNull('proinvoice_id')->count();
    }
    /**
     * Returns Created Invoices (No Proinvoice Associated With) Not Issued, Not Paid  With Pagination
     *
     * @return \App\Invoice
     */
    public function get_invoices_not_issued_not_paid_pagination($pagination = 10){   
        return  Invoice::where('is_issued',0)->where('is_paid',0)->whereNull('proinvoice_id')->paginate($pagination);

    }


    /**
     * Returns Number Of Issued Invoices (No Proinvoice Associated With)  Not Paid  
     *
     * @return int
     */
    public function count_invoices_issued_not_paid(){   
        return  Invoice::where('is_issued',1)->where('is_paid',0)->whereNull('proinvoice_id')->count();
    }
    /**
     * Returns Issued Invoices (No Proinvoice Associated With) Not Paid  With Pagination
     *
     * @return \App\Invoice
     */
    public function get_invoices_issued_not_paid_pagination($pagination = 10){   
        return  Invoice::where('is_issued',1)->where('is_paid',0)->whereNull('proinvoice_id')->paginate($pagination);

    }


    /**
     * Returns All Paid Invoices  With Pagination
     *
     * @return \App\Invoice
     */
    public function get_invoices_paid($pagination = 10){   
        return  Invoice::where('is_paid',1)->paginate($pagination);

    }


    /**
     * Returns Client's Presentation Invoices
     *
     * @param  int $client_id
     * @return  \App\Invoice
     */
    public function get_clients_presentation_invoices($client_id){
        return  Invoice::where('contract_id', 0)
                        ->where('proinvoice_id', null)
                        ->where('client_id', $client_id)
                        ->get();
    }


    /**
     * Returns Number Of Invoices Paid Last Month 
     *
     * @param  string $first_day
     * @param  string $last_day
     * @return  int
     */
    public function count_last_month_paid_invoices($first_day, $last_day){
        return Invoice::where('is_paid', 1)->whereBetween('paid_date', [$first_day, $last_day])->count();
    }

    /**
     * Returns Number Of Invoices Paid Last Month
     *
     * @param  string $first_day
     * @param  string $last_day
     * @return  int
     */
    public function count_last_month_pdv_debt($first_day, $last_day){
        return  Invoice::where('is_paid', 1)->whereBetween('paid_date', [$first_day, $last_day])->count();  
    }
    /**
     * Returns Total PDV Debt (Paid Invoices Value) RSD Value Issued Last Month
     *
     * @param  string $first_day
     * @param  string $last_day
     * @return  \App\Invoice
     */
    public function get_last_month_pdv_debt($first_day, $last_day){
        return  Invoice::select(DB::raw('SUM(value_din) as invoice_din_total'),
                                        DB::raw('SUM(pdv_din) as pdv_din_total'),
                                        DB::raw('SUM(value_din_tax) as value_din_tax_total'))
                        ->where('is_paid', 1)
                        ->whereBetween('paid_date', [$first_day, $last_day])
                        ->first();
    }



    /**
     * Returns Number Of Paid, Not Issued Presentation Invoices Associated With Paid Proinvoices-Advance 
     *
     * @return int     
     */
    public function count_clients_presentation_invoices_paid_not_issued($client_id){   
        return  Invoice::where('client_id', $client_id)
                        ->where('contract_id', 0)
                        ->where('is_paid', 1)
                        ->where('is_issued', 0)
                        ->count();
    }

    /**
     * Returns Number Of Issued, Not Paid Presentation Invoices 
     *
     * @return int     
     */
    public function count_clients_presentation_invoices_issued_not_paid($client_id){   
        return  Invoice::where('client_id', $client_id)
                        ->where('contract_id', 0)
                        ->where('is_paid', 0)
                        ->where('is_issued', 1)
                        ->count();
    }


    /**
     * Set Invoice Status Issued  
     *
     * @param  \App\Invoice $invoice
     * @return bool     
     */
    public function set_invoice_issued(Invoice $invoice){   
        return  $invoice->update(['is_issued'=> 1]);
    }

    /**
     * Set Invoice From Proinvoice Status Issued  
     *
     * @param  \App\Invoice $invoice
     * @param  int $serial_number
     * @param  string $invoice_number 
     * @return bool     
     */
    public function set_invoice_from_proinvoice_issued(Invoice $invoice, $serial_number, $invoice_number){   
        return   $invoice->update(['is_issued' => 1, 
                                   'is_paid' => 1, 
                                   'serial_number' => $serial_number, 
                                   'invoice_number' => $invoice_number]);
    }

    /**
     * Set Invoice Status Paid  
     *
     * @param  \App\Invoice $invoice
     * @param  string $pdv_paying_date
     * @return bool     
     */
    public function set_invoice_paid(Invoice $invoice, $pdv_paying_date){   
        return  $invoice->update(['is_paid' => 1, 
                                  'paid_date' => date('Y-m-d'), 
                                  'pdv_paid_date' => $pdv_paying_date]);
    }


    /**
     * Delete Invoice From Proinvoice
     *
     * @param  int $proinvoice_id
     * @return bool     
     */
    public function delete_invoice_from_proinvoice($proinvoice_id){   
        return  Invoice::where('proinvoice_id', $proinvoice_id)->delete();
    }

      

}


