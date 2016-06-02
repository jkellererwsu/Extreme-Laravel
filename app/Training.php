<?php

namespace App;

use Carbon\Carbon;
use App\Scopes\ChurchScope;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'name',
        'displayOrder',
        'short_name',
        'category',
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

    /**
     * The "booting" method of the model.
     *
     * Add Global Scope to limit contacts to current logged in user Church
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ChurchScope);
    }
}
