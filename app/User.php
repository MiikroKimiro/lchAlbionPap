<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verified', 'isAdmin', 'isOfficer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function leadEvents()
    {
        return $this->hasMany(Event::class, 'lead_id');
    }

    public function participations()
    {
        return $this->belongsToMany(Event::class, 'event_participant', 'user_id', 'event_id');
    }

    public function thisMonthParticipations()
    {
        $first = Carbon::now()->startOfMonth()->toDateTimeString();
        $last = Carbon::now()->endOfMonth()->toDateTimeString();
        
        return $this->participations()
            ->where('created_at', '>=', $first)
            ->where('created_at', '<=', $last);
    }
    
    public function lastMonthParticipations()
    {
        $first = Carbon::now()->startOfMonth()->toDateTimeString();
        $last = Carbon::now()->endOfMonth()->toDateTimeString();
        return $this->participations()
            ->where('created_at', '>=', $first)
            ->where('created_at', '<=', $last);
    }

}
