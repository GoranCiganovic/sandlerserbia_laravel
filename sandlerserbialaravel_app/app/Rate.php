<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sandler', 'sandler_paying_day', 'pdv', 'pdv_paying_day','disc', 'devine', 'disc_devine', 'dd_paying_day', 'ppo'
    ];

    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;



    /**
     * Returns Rate (Sandler Percent, Sandler Paying Day, PDV Percent, PDV Paying Day, DISC, Devine, DISC/Devine, DISC/Devine Paying Day, PPO Percent)
     *
     * @return \App\Rate
     */
    public function get_rate(){
        return  Rate::where('id', 1)->first();
    }


    /**
     * Returns Sandler Percent
     *
     * @return float
     */
    public function get_sandler_percent(){
        return  Rate::where('id', 1)->first()->sandler;
    }

    /**
     * Returns Sandler Paying Day
     *
     * @return int
     */
    public function get_sandler_paying_day(){
        return  Rate::where('id', 1)->first()->sandler_paying_day;
    }

    /**
     * Returns PDV Percent
     *
     * @return float
     */
    public function get_pdv_percent(){
        return  Rate::where('id', 1)->first()->pdv;
    }

    /**
     * Returns PDV Percent Based on Legal Status
     *
     * @param  int $legal_status
     * @return  float
     */
    public function get_pdv_percent_by_legal_status($legal_status){
       return $legal_status == 1 ? $this->get_pdv_percent() : '0.00';   
    }

    /**
     * Returns PDV Paying Day
     *
     * @return int
     */
    public function get_pdv_paying_day(){
        return  Rate::where('id', 1)->first()->pdv_paying_day;
    }

    /**
     * Returns PPO Percent
     *
     * @return float
     */
    public function get_ppo_percent(){
        return  Rate::where('id', 1)->first()->ppo;
    }

    /**
     * Returns DISC Value (USD)
     *
     * @return float
     */
    public function get_disc(){
        return  Rate::where('id', 1)->first()->disc;
    }

    /**
     * Returns Devine Value (USD)
     *
     * @return float
     */
    public function get_devine(){
        return  Rate::where('id', 1)->first()->devine;
    }

    /**
     * Returns DISC/Devine Value (USD)
     *
     * @return float
     */
    public function get_disc_devine(){
        return  Rate::where('id', 1)->first()->disc_devine;
    }

    /**
     * Returns DISC/Devine Paying Day
     *
     * @return int
     */
    public function get_dd_paying_day(){
        return  Rate::where('id', 1)->first()->dd_paying_day;
    }
}
