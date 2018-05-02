<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySize extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'size'
    ];
    
    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Legal that owns the Company Size.
     */
    public function legal()
    {
        return $this->hasOne('App\Legal',  'company_size_id');
    }

    /**
     * Returns All Company Sizes
     *
     * @return \App\CompanySize
     */
    public function get_company_sizes(){   
        return CompanySize::get();
    }

    /**
     * Returns Company Size By Id
     *
     * @param $company_size_id
     * @return \App\CompanySize
     */
    public function get_company_size_by_id($company_size_id){   
        return CompanySize::find($company_size_id);
    }
}
