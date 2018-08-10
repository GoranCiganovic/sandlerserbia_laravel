<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractParticipant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'contract_id', 'participant_id'
    ];

    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;
}
