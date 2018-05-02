<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientStatus extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'local_name', 'local_icon', 'global_name', 'global_icon', 'text_color'
    ];

    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Legal that owns the Client Status.
     */
    public function legal()
    {
        return $this->hasOne('App\Legal',  'client_status_id');
    }

    /**
     * Get the Individual that owns the Client Status.
     */
    public function individual()
    {
        return $this->hasOne('App\Individual',  'client_status_id');
    }

    /**
     * Returns Client Status By Status Id
     *
     * @param  int $client_status_id
     * @return  \App\ClientStatus
     */
    public function get_client_status_by_client_status_id($client_status_id){
        return ClientStatus::select('local_name','local_icon','global_name','global_icon')
                            ->where('client_statuses.id', $client_status_id)
                            ->first();
    }

}
