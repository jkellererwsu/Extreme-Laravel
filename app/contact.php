<?php

namespace App;

use Auth;
use Carbon\Carbon;
use App\Scopes\ChurchScope;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    protected $fillable = [
		'fname',
		'lname',
		'church_id',
        'user_id',
        'leader_id',
        'group_id',
		'bday',
		'address',
		'city',
		'phone',
		'email',
		'position_id',
		'anniversary'
	];

    protected $dates = ['bday', 'anniversary'];


    public function scopeOnlyposition($query, $currentcontact, $positionid){
        //$query->where('position_id', '=',  1)->where('id', '!=', $currentcontact);
        $query->where('id', '!=', $currentcontact)->whereHas('positions', function($q) use($positionid){
            $q->where('position_id', '=', $positionid);
        });

    }
    public function getBdayAttribute($date)
    {
        return Carbon::parse($date);
    }
    public function getAnniversaryAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
    }

	public function user()
	{
		return $this->belongsTo('App\User', 'creator_id');
	}

	public function connectedUser()
	{
		return $this->hasOne('App\User', 'contact_id');
	}

	public function church()
	{
		return $this->belongsTo('App\church');
	}

    public function follower()
    {
        return $this->hasMany('App\contact', 'leader_id');
    }

    public function leader()
    {
        return $this->belongsTo('App\contact', 'leader_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')->withPivot('id','date', 'note')->orderBy('displayOrder', 'asc')->orderBy('date', 'desc')->withTimestamps();
    }

    public function groupLeader()
    {
        return $this->hasOne('App\Group', 'leader_id');
    }
    public function groupHost()
    {
        return $this->hasOne('App\Group', 'host_id');
    }
    public function groupTimothy()
    {
        return $this->hasOne('App\Group', 'timothy_id');
    }

    public function positions()
    {
        return $this->belongsToMany('App\Position')->withTimestamps();
    }

    public function getPositionListAttribute()
    {
        return $this->positions->lists('id')->all();
    }

    public function events()
    {
        return $this->belongsToMany('App\Event')->withTimestamps()->withPivot('date', 'note');
    }
    public function trainings()
    {
        return $this->belongsToMany('App\Training')->withTimestamps()->withPivot('date', 'note');
    }

    public function services()
    {
        return $this->belongsToMany('App\Service')->withPivot('id','date', 'note')->orderBy('displayOrder', 'asc')->orderBy('date', 'desc')->withTimestamps();
    }

	public function tags()
	{
        return $this->belongsToMany('App\Tag')->withTimestamps();
	}
	public function getTagListAttribute()
	{
		return $this->tags->lists('id')->all();
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