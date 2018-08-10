<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['legal_status_id'];

    /**
     * Get the Legal Status record associated with the Client.
     */
    public function legal_status()
    {
        return $this->belongsTo('App\LegalStatus');
    }

    /**
     * Get the legal record associated with the Client.
     */
    public function legal()
    {
        return $this->hasOne('App\Legal', 'client_id');
    }

    /**
     * Get the Individual record associated with the Client.
     */
    public function individual()
    {
        return $this->hasOne('App\Individual', 'client_id');
    }

    /**
     * Get the Contract record associated with the Client.
     */
    public function contract()
    {
        return $this->hasMany('App\Contract', 'client_id');
    }

    /**
     * Returns Number Of Clients With Accept Meeting Status (Legal and Individual)
     *
     * @return int
     */
    public function count_accept_meeting_clients()
    {
        return Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 3)
            ->orWhere('individuals.client_status_id', 3)
            ->count();
    }

    /**
     * Returns Number Of Clients With JPB Status (Legal and Individual)
     *
     * @return int
     */
    public function count_jpb_clients()
    {
        return Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 4)
            ->orWhere('individuals.client_status_id', 4)
            ->count();
    }

    /**
     * Returns Client (Legal Or Individual)
     *
     * @param  \App\Client $client
     * @return \App\Client
     */
    public function get_client(Client $client)
    {
        if ($client->legal_status_id == 1) {
            $client = $client->legal;
        }
        if ($client->legal_status_id == 2) {
            $client = $client->individual;
        }
        return $client;
    }

    /**
     * Returns Client By Client Id
     *
     * @param  int $client_id
     * @return  \App\Client
     */
    public function get_client_by_client_id($client_id)
    {
        return Client::find($client_id);
    }

    /**
     * Set Client Status
     *
     * @param \App\Client $client
     * @param string $status_id
     * @return bool
     */
    public function set_client_status(Client $client, $status_id)
    {
        if ($client->legal_status_id == 1) {
            $update = $client->legal->update(['client_status_id' => $status_id]);
        }
        if ($client->legal_status_id == 2) {
            $update = $client->individual->update(['client_status_id' => $status_id]);
        }
        return $update;
    }

    /**
     * Set Client (Legal Or Individual) Closing Date
     *
     * @param  mixed $client (Legal/Individual)
     * @return bool
     */
    public function set_closing_date($client)
    {
        return $client->update(['closing_date' => date('Y-m-d')]);
    }

    /**
     * Get Input Search Clients
     *
     * @param string $input_search,
     * @param array $legal_status_array
     * @param string $legal_name
     * @param string $individual_first_name
     * @param string $individual_last_name
     * @param string $order_by
     * @param int $pagination
     * @return \App\Client
     */
    public function search_input_clients_pagination($input_search, $legal_status_array, $legal_name, $individual_first_name, $individual_last_name, $order_by, $pagination = 10)
    {
        return Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->leftJoin('legal_statuses', 'clients.legal_status_id', '=', 'legal_statuses.id')
            ->select(
                'clients.id as id',
                'legals.id as legal_id',
                'legals.long_name as legal_name',
                DB::raw('CONCAT(first_name," ", last_name) AS individual_name'),
                'legal_statuses.icon as legal_icon'
            )
            ->where('legals.long_name', 'LIKE', "$input_search%")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$legal_name $order_by")
            ->orWhere('individuals.first_name', 'LIKE', "$input_search%")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_first_name $order_by")
            ->orWhere('individuals.last_name', 'LIKE', "$input_search%")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_last_name $order_by")
            ->paginate($pagination);
    }

    /**
     * Get Clients By Client Status
     *
     * @param string $search,
     * @param int $client_status
     * @param array $legal_status_array
     * @param string $legal_name
     * @param string $individual_first_name
     * @param string $individual_last_name
     * @param string $order_by
     * @param int $pagination
     * @return \App\Client
     */
    public function search_clients_by_client_status_pagination($search, $client_status, $legal_status_array, $legal_name, $individual_first_name, $individual_last_name, $order_by, $pagination = 10)
    {
        return Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->leftJoin('legal_statuses', 'clients.legal_status_id', '=', 'legal_statuses.id')
            ->select(
                'clients.id as id',
                'legals.id as legal_id',
                'legals.long_name as legal_name',
                'individuals.id as individual_id',
                DB::raw('CONCAT(first_name," ", last_name) AS individual_name'),
                'legal_statuses.icon as legal_icon'
            )
            ->where('legals.long_name', 'LIKE', "$search%")
            ->where('legals.client_status_id', '=', "$client_status")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$legal_name $order_by")
            ->orWhere('individuals.first_name', 'LIKE', "$search%")
            ->where('individuals.client_status_id', '=', "$client_status")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_first_name $order_by")
            ->orWhere('individuals.last_name', 'LIKE', "$search%")
            ->where('individuals.client_status_id', '=', "$client_status}")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_last_name $order_by")
            ->paginate($pagination);
    }
}
