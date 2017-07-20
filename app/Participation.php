<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = ['eventID', 'userID'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
