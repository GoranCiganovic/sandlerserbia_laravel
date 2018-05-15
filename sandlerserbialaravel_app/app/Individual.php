<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Individual extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'jmbg', 'id_card', 'works_at', 'address', 'county', 'postal', 'city', 'conversation_date', 'accept_meeting_date', 'meeting_date', 'closing_date', 'comment', 'client_status_id', 'client_id',
    ];

    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Client that owns the Individual.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the Client Status record associated with the Individual.
     */
    public function client_status()
    {
        return $this->belongsTo('App\ClientStatus');
    }

    /**
     * Returns Individuals With Meeting Date Range
     *
     * @param string $from
     * @param string $until
     * @return \App\Individual
     */
    public function get_individuals_meeting_date_range($from, $until)
    {
        return Individual::select(
            DB::raw('CONCAT(first_name," ", last_name) AS name'),
            DB::raw('DATE_FORMAT(meeting_date, "%W, %e. %M %Y. u %H:%i") as meeting_date'),
            'client_id'
        )
            ->whereBetween('meeting_date', [$from, $until])
            ->get();
    }
}
