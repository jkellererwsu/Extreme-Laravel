<?php

namespace App;

use Carbon\Carbon;
use App\Scopes\ChurchScope;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'day',
        'time',
        'address',
        'city',
        'founded',
        'church_id',
        'leader_id',
        'host_id',
        'timothy_id'

    ];

    protected $dates = ['founded'];

    public function getFoundedAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function church()
    {
        return $this->belongsTo('App\church', 'church_id');
    }

    public function contact()
    {
        return $this->hasMany('App\contact');
    }
    public function contacts()
    {
        return $this->belongsToMany('App\contact')->withPivot('id','date', 'note')->orderBy('date', 'desc')->withTimestamps();
    }
    public function leader()
    {
        return $this->belongsTo('App\contact', 'leader_id');
    }
    public function host()
    {
        return $this->belongsTo('App\contact', 'host_id');
    }
    public function timothy()
    {
        return $this->belongsTo('App\contact', 'timothy_id');
    }

    public function scopeCountByDate($query, $date, $group_id){

        return $query->join('contact_group', 'groups.id', '=', 'contact_group.group_id')
            ->where('date', '=', $date)
            ->where('group_id', '=', $group_id)->count();
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
