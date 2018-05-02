<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegalStatus extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'name', 'icon'
    ];

    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Client that owns the Legal Status.
     */
    public function client()
    {
        return $this->hasOne('App\Client',  'legal_status_id');
    }
}
