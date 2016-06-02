<?php

namespace App;

use Carbon\Carbon;
use App\Scopes\AttendanceScope;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'service_id',
        'adults',
        'kids',
        'extremies',
        'offering',
        'tithe',
        'other_income',
        'note',
        'date'
    ];

    protected $dates = ['date'];

    public function getDateAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AttendanceScope);
    }



}
