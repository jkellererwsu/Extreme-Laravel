<?php

namespace App;

use Carbon\Carbon;
use App\Scopes\ChurchScope;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'displayOrder',
        'type',
    ];




    public function scopeCountByDate($query, $date, $service_id){

        return $query->join('contact_service', 'services.id', '=', 'contact_service.service_id')
            ->where('date', '=', $date)
            ->where('service_id', '=', $service_id)->count();
    }


    public function attendance()
    {
        return $this->hasMany('App\Attendance')->orderBy('date', 'desc');
    }

    /**
     * The "booting" method of the model.
     *
     * Add Global Scope to limit groups to current logged in user Church
     * @return void
     */

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ChurchScope);
    }

}
