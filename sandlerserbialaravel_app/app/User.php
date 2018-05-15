<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'is_admin', 'is_unauthorized',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Returns Admin Email Address
     *
     * @return string
     */
    public function get_admin_email()
    {
        return User::where('id', 1)->where('is_admin', 1)->value('email');
    }

    /**
     * Returns Non-Administrator Users
     *
     * @return \App\Users
     */
    public function get_non_admin_users()
    {
        return User::where('is_admin', 0)->get();
    }
}
