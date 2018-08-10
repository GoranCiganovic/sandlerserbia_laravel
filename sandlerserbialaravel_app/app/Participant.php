<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'position', 'email', 'phone', 'dd_date'];
 
    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The Contract that belong to the Participant.
     */
    public function contract()
    {
        return $this->belongsToMany('App\Contract', 'contract_participants', 'contract_id', 'participant_id');
    }
    

    /**
     * Get the DiscDevine that owns the Participant.
     */
    public function disc_devine()
    {
        return $this->hasOne('App\DiscDevine', 'participant_id');
    }
}
