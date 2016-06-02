<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'displayOrder',
        'date',
        'note'
    ];

    protected $dates = ['date'];

    public function getDateAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function contacts()
    {
        return $this->belongsToMany('App\contact')->withPivot('date', 'note');
    }


}
