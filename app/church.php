<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class church extends Model
{
    protected $fillable = [
        'name',
        'city',
        'country',
        'address',
        'district'

    ];
    public function users()
    {
        return $this->hasMany('App\User');
    }
    public function contacts()
    {
        return $this->hasMany('App\contact');
    }
    public function groups()
    {
        return $this->hasMany('App\Group', 'church_id');
    }
}
