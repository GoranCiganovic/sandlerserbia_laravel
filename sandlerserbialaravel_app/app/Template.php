<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo_bg', 'logo_hd', 'line_hd', 'line_ft','paginate', 'margin_top', 'margin_right', 'margin_bottom', 'margin_left'

    ];

    /**
     * The attribute timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns Template Options
     *
     * @return  \App\Template
     */
    public function get_template_options(){
        return  Template::first();

    }
}
