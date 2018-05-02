<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalTraining extends Model
{
   	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'representative', 'phone', 'email','website', 'address', 'county', 'postal','city', 'bank', 'account', 'pib','identification'
    ];

   	/**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns Global Traning Data (First Row)
     *
     * @return \App\GlobalTraining
     */
    public function get_global_training(){   
        return  GlobalTraining::first();
    }
}


