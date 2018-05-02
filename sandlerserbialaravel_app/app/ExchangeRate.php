<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ExchangeRate extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency', 'value'
    ];

    /**
     * Returns All Exchange Rate Data
     *
     * @return \App\ExchangeRate
     */
    public function get_all_exchange_rate(){
        return  ExchangeRate::all();
    }

    /**
     * Returns Current Euro Exchange
     *
     * @return string
     */
    public function get_current_exchange_euro(){   
        return ExchangeRate::where('currency','EUR')->value('value');
    }

    /**
     * Returns Current Dollar Exchange
     *
     * @return string
     */
    public function get_current_exchange_dollar(){   
        return ExchangeRate::where('currency','USD')->value('value');
    }

    /**
     * Update Currency 
     *
     * @return bool
     */
    public function update_currency($currency, $value){   
         return ExchangeRate::where('currency', $currency)->update(['value' => $value, 'updated_at' => Carbon::now()]);
    }

 
}

