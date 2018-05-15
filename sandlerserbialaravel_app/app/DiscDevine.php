<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DiscDevine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'disc_dollar', 'devine_dollar', 'dd_dollar', 'middle_ex_dollar', 'make_date', 'paid_date', 'dd_din', 'ppo', 'ppo_din', 'is_paid', 'participant_id',
    ];

    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Participant record associated with the DiscDevine.
     */
    public function participant()
    {
        return $this->belongsTo('App\Participant');
    }

    /**
     * Returns Number Of DISC/Devine Tests Make Date Last Month
     *
     * @param  string $first_day
     * @param  string $last_day
     * @return  int
     */
    public function count_last_month_disc_devine_debt($first_day, $last_day)
    {
        return DiscDevine::whereBetween('make_date', [$first_day, $last_day])->count();
    }

    /**
     * Returns Total DISC/Devine Tests USD Value Make Date Last Month
     *
     * @param  string $first_day
     * @param  string $last_day
     * @return  float
     */
    public function get_last_month_disc_devine_debt($first_day, $last_day)
    {
        return DiscDevine::select(DB::raw('SUM(dd_dollar) as dd_dollar_total'))
            ->whereBetween('make_date', [$first_day, $last_day])
            ->first()->dd_dollar_total;
    }

    /**
     * Returns Number Of DISC/Devine Tests Not Paid And With Paid Date Before Today (Home Page)
     *
     * @return int
     */
    public function count_disc_devine_debt_deadline_expired()
    {
        return DiscDevine::where('is_paid', 0)->where('paid_date', '<=', date('Y-m-d'))->count();
    }

    /**
     * Returns DISC/Devine Tests Not Paid And With Paid Date Before Today
     *
     * @return  \App\DiscDevine
     */
    public function get_disc_devine_debt_deadline_expired()
    {
        return DiscDevine::where('is_paid', 0)->where('paid_date', '<=', date('Y-m-d'))->get();
    }

    /**
     * Returns Number DiscDevine Tests Not Paid With Paid Date On Today
     *
     * @return int
     */
    public function count_unpaid_disc_devine_payday_today()
    {
        return DiscDevine::where('is_paid', 0)->where('paid_date', date('Y-m-d'))->count();
    }

    /**
     * Update DISC/Devine Tests Not Paid With Paid Date On Today
     *
     * @param  float $middle_ex_dollar
     * @param  float $ppo
     * @return bool
     */
    public function update_unpaid_disc_devine_payday_today($middle_ex_dollar, $ppo)
    {
        return DiscDevine::where('is_paid', 0)->where('paid_date', date('Y-m-d'))
            ->update([
                'middle_ex_dollar' => $middle_ex_dollar,
                'dd_din' => DB::raw('dd_dollar*middle_ex_dollar'),
                'ppo' => $ppo,
                'ppo_din' => DB::raw('(dd_din*ppo)/100'),
                'is_paid' => 1,
            ]);
    }
}
