<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['lead_id', 'name', 'type', 'comment', 'hashed_id'];

    protected $appends = ['lead_name', 'pap_link', 'status'];

    public function lead()
    {
        return $this->belongsTo(User::class, 'lead_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participant', 'event_id', 'user_id');
    }

    public function scopeThisMonth($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->startOfMonth());
    }

    public function getLeadNameAttribute()
    {
        return $this->lead->name;
    }
    public function getPapLinkAttribute()
    {
        return 'http://pap.smn.ovh/events/' . $this->hashed_id;
    }
    public function getStatusAttribute()
    {
        $limit = Carbon::parse($this->created_at)->addHours(1);
        $now = Carbon::now();
        $test = $now->lte($limit);
        
        if($test)
        {
            return 'open';
        } else {
            return 'closed';
        }
    }
}
