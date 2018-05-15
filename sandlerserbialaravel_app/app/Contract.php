<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contract_number', 'description', 'contract_date', 'participants', 'event_place', 'classes_number', 'start_date', 'end_date', 'work_dynamics', 'event_time', 'value', 'value_letters', 'advance', 'paid', 'rest', 'payments', 'html', 'contract_status_id', 'legal_status_id', 'client_id'];

    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Client that owns the Contract.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the Contract Status record associated with the Contract.
     */
    public function contract_status()
    {
        return $this->belongsTo('App\ContractStatus');
    }

    /**
     * The Participant that belong to the Contract.
     */
    public function participant()
    {
        return $this->belongsToMany('App\Participant');
    }

    /**
     * Get the Participants associated with the Contract with Pagination.
     */
    public function participant_paginate(Contract $contract, $paginate = 10)
    {
        return $contract->participant()->paginate($paginate);
    }

    /**
     * Get the Payment record associated with the Contact.
     */
    public function payment()
    {
        return $this->hasMany('App\Payment', 'contract_id');
    }

    /**
     * Get the Payments associated with the Contract with Pagination.
     */
    public function payment_paginate(Contract $contract, $paginate = 10)
    {
        return $contract->payment()->paginate($paginate);
    }

    /**
     * Get the Invoice record associated with the Contact.
     */
    public function invoice()
    {
        return $this->hasMany('App\Invoice', 'contract_id');
    }

    /**
     *  Stores Null if Input Value Is Empty on Insert and Update for Start Date and End Date.
     */
    protected static function boot()
    {
        static::creating(function ($model) {
            $model->start_date = empty($model->start_date) ? null : $model->start_date;
        });
        static::updating(function ($model) {
            $model->start_date = empty($model->start_date) ? null : $model->start_date;
        });

        static::creating(function ($model) {
            $model->end_date = empty($model->end_date) ? null : $model->end_date;
        });
        static::updating(function ($model) {
            $model->end_date = empty($model->end_date) ? null : $model->end_date;
        });
    }

    /**
     * Returns Number of Unsigned Contracts
     *
     * @return int
     */
    public function count_unsigned_contracts()
    {
        return Contract::where('contract_status_id', 1)->count();
    }

    /**
     * Returns Unsigned Contracts With Pagination
     *
     * @return \App\Contract
     */
    public function get_unsigned_contracts_pagination($paginate = 10)
    {
        return Contract::where('contract_status_id', 1)->paginate($paginate);
    }

    /**
     * Returns Number Of In Progress Contracts
     *
     * @return int
     */
    public function count_in_progress_contracts()
    {
        return Contract::where('contract_status_id', 2)->count();
    }

    /**
     * Returns In Progress Contracts With Pagination
     *
     * @return \App\Contract
     */
    public function get_in_progress_contracts_pagination($paginate = 10)
    {
        return Contract::where('contract_status_id', 2)->paginate($paginate);
    }

    /**
     * Returns Number Of Finished Contracts
     *
     * @return int
     */
    public function count_finished_contracts()
    {
        return Contract::where('contract_status_id', 3)->count();
    }

    /**
     * Returns Finished Contracts With Pagination
     *
     * @return \App\Contract
     */
    public function get_finished_contracts_pagination($paginate = 10)
    {
        return Contract::where('contract_status_id', 3)->paginate($paginate);
    }

    /**
     * Returns Number Of Broken Contracts
     *
     * @return int
     */
    public function count_broken_contracts()
    {
        return Contract::where('contract_status_id', 4)->count();
    }

    /**
     * Returns Broken Contracts With Pagination
     *
     * @return \App\Contract
     */
    public function get_broken_contracts_pagination($paginate = 10)
    {
        return Contract::where('contract_status_id', 4)->paginate($paginate);
    }

    /**
     * Returns Last Contract Number
     *
     * @return int
     */
    public function get_last_contract_number()
    {
        return Contract::max('contract_number');
    }

    /**
     * Returns Number In Progress Client Contracts
     *
     * @param  int $client_id
     * @return int
     */
    public function count_clients_in_progress_contracts($client_id)
    {
        return Contract::where('client_id', $client_id)
            ->where('contract_status_id', 2)
            ->count();
    }

    /**
     * Returns Number In Progress Client Contracts Except Passed Contract
     *
     * @param  \App\Contract $contract
     * @return int
     */
    public function count_clients_other_in_progress_contracts(Contract $contract)
    {
        return $contract->where('client_id', $contract->client_id)
            ->where('contract_status_id', 2)
            ->whereNotIn('id', [$contract->id])
            ->count();
    }

    /**
     * Set Contract Status
     *
     * @param \App\Contract $contract
     * @param string $status_id
     * @return void
     */
    public function set_contract_status(Contract $contract, $status_id)
    {
        return $contract->update(['contract_status_id' => $status_id]);
    }

    /**
     * Update Contract Paid And Rest Values
     *
     * @param \App\Contract $contract
     * @param float $paid
     * @param float $rest
     * @return void
     */
    public function update_contract_paid_and_rest(Contract $contract, $paid, $rest)
    {
        return $contract->update(['paid' => $paid, 'rest' => $rest]);
    }
}
