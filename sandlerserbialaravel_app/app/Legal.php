<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Legal extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'long_name', 'short_name', 'ceo', 'phone', 'email', 'contact_person', 'contact_person_phone', 'identification', 'pib', 'activity', 'address', 'county', 'postal','city', 'website', 'conversation_date', 'accept_meeting_date', 'meeting_date', 'closing_date', 'comment', 'company_size_id', 'client_status_id', 'client_id'
    ];
 
    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Client that owns the Legal.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the Client Status record associated with the Legal.
     */
    public function client_status()
    {
        return $this->belongsTo('App\ClientStatus');
    }

    /**
     * Get the Company Size record associated with the Legal.
     */
    public function company_size()
    {
        return $this->belongsTo('App\CompanySize');
    }


    /**
     * Returns Legals With Meeting Date Range
     *
     * @param string $from
     * @param string $until
     * @return \App\Legal
     */
    public function get_legals_meeting_date_range($from, $until)
    {
        return  Legal::select('long_name as name',
                               DB::raw('DATE_FORMAT(meeting_date, "%W, %e. %M %Y. u %H:%i") as meeting_date'),
                               'client_id')
                    ->whereBetween('meeting_date', [$from,$until])
                    ->get();
    }


}
