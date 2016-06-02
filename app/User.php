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
        'username', 'email', 'password','church_id','contact_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function contacts()
    {
        return $this->hasMany('App\contact', 'creator_id');
    }

    public function myContact()
    {
        return $this->belongsTo('App\contact', 'contact_id');
    }
    public function church()
    {
        return $this->belongsTo('App\church');
    }


}