<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'name', 'icon', 'color',
    ];

    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Contract that owns the Contract Status.
     */
    public function contract()
    {
        return $this->hasOne('App\Contract', 'contract_status_id');
    }
}
