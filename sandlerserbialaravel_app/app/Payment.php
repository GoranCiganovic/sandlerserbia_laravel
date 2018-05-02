<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'value_euro', 'pay_date', 'pay_date_desc','description', 'is_advance', 'is_issued', 'is_paid', 'contract_id'
    ];

    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Contract that owns the Payment.
     */
    public function contract()
    {
        return $this->belongsTo('App\Contract');
    }

    /**
     * Returns Number Of Payments Advance , No Issued, No Paid, Today Paying Date and Contract Status In Progress
     *
     * @return int     
     */
    public function count_payments_advance_issue_today(){   
        return Payment::join('contracts', 'contracts.id', '=', 'payments.contract_id')
                    ->where('payments.is_advance',1)
                    ->where('payments.is_issued',0)
                    ->where('payments.is_paid',0)
                    ->where('payments.pay_date',date('Y-m-d'))
                    ->where('contracts.contract_status_id', 2)
                    ->count();              
    }

    /**
     * Returns Payments Advance, Not Issued, Not Paid, Contract Status In Progress, Pay Date On Today With Pagination
     *
     * @return \App\Payment
     */
    public function get_payments_advance_issue_today_pagination($paginate = 10){   
        return  Payment::select('payments.id as id',
                                'payments.pay_date as pay_date', 
                                'payments.value_euro as value_euro',
                                'payments.contract_id as contract_id',
                                'contracts.contract_number as contract_number',
                                'contracts.contract_date as contract_date')
                        ->join('contracts', 'contracts.id', '=', 'payments.contract_id')
                        ->where('payments.is_advance',1)
                        ->where('payments.is_issued',0)
                        ->where('payments.is_paid',0)
                        ->where('payments.pay_date',date('Y-m-d'))
                        ->where('contracts.contract_status_id',2)
                        ->paginate($paginate);
    }

    /**
     * Returns Number Of Payments Non Advance , No Issued, No Paid, Today Paying Date and Contract Status In Progress
     *
     * @return int     
     */
    public function count_payments_non_advance_issue_today(){   
        return Payment::join('contracts', 'contracts.id', '=', 'payments.contract_id')
                    ->where('payments.is_advance',0)
                    ->where('payments.is_issued',0)
                    ->where('payments.is_paid',0)
                    ->where('payments.pay_date',date('Y-m-d'))
                    ->where('contracts.contract_status_id', 2)
                    ->count();              
    }


    /**
     * Returns Payments Advance , No Issued, No Paid, Tomorrow Paying Date and Contract Status In Progress
     *
     * @return int     
     */
    public function get_payments_advance_issue_tomorrow(){   
        return Payment::select('payments.id as payment_id', 
                               'contracts.id as contract_id',
                               'payments.value_euro as payment_value_euro',
                               'contracts.contract_number as contract_number',
                               'contracts.contract_date as contract_date' )
                    ->join('contracts', 'contracts.id', '=', 'payments.contract_id')
                    ->where('payments.is_advance',1)
                    ->where('payments.is_issued',0)
                    ->where('payments.is_paid',0)
                    ->where('payments.pay_date',date('Y-m-d', strtotime("+1 day")))
                    ->where('contracts.contract_status_id', 2)
                    ->get();              
    }

    /**
     * Returns  Payments Non Advance , No Issued, No Paid, Tomorrow Paying Date and Contract Status In Progress
     *
     * @return int     
     */
    public function get_payments_non_advance_issue_tomorrow(){   
        return Payment::select('payments.id as payment_id', 
                               'contracts.id as contract_id',
                               'payments.value_euro as payment_value_euro',
                               'contracts.contract_number as contract_number',
                               'contracts.contract_date as contract_date' )
                    ->join('contracts', 'contracts.id', '=', 'payments.contract_id')
                    ->where('payments.is_advance',0)
                    ->where('payments.is_issued',0)
                    ->where('payments.is_paid',0)
                    ->where('payments.pay_date',date('Y-m-d', strtotime("+1 day")))
                    ->where('contracts.contract_status_id', 2)
                    ->get();              
    }


    /**
     * Returns Payments Non Advance, Not Issued, Not Paid, Contract Status In Progress, Pay Date On Today With Pagination
     *
     * @return \App\Payment
     */
    public function get_payments_non_advance_issue_today_pagination($paginate = 10){   
        return  Payment::select('payments.id as id',
                                'payments.pay_date as pay_date', 
                                'payments.value_euro as value_euro',
                                'payments.contract_id as contract_id',
                                'contracts.contract_number as contract_number',
                                'contracts.contract_date as contract_date')
                        ->join('contracts', 'contracts.id', '=', 'payments.contract_id')
                        ->where('payments.is_advance',0)
                        ->where('payments.is_issued',0)
                        ->where('payments.is_paid',0)
                        ->where('payments.pay_date',date('Y-m-d'))
                        ->where('contracts.contract_status_id',2)
                        ->paginate($paginate);
    }


    /**
     * Set Payment Status Issued  
     *
     * @param  \App\Payment $payment
     * @return bool     
     */
    public function set_payment_issued(Payment $payment){   
        return  $payment->update(['is_issued' => 1]);
    }

    /**
     * Set Payment Status Not Issued  
     *
     * @param  \App\Payment $payment
     * @return bool     
     */
    public function set_payment_not_issued(Payment $payment){   
        return  $payment->update(['is_issued' => 0]);
    }

    /**
     * Set Payment Status Paid  
     *
     * @param  \App\Payment $payment
     * @return bool     
     */
    public function set_payment_paid(Payment $payment){   
        return  $payment->update(['is_paid' => 1]);
    }

    
}
