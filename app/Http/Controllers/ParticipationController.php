<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{
    public function getNewEvent()
    {
        $members_list = User::lists('name', 'id');
        $userID = Auth::user()->id;
        $userName = Auth::user()->name;
        return view('participation/new-event', compact('members_list', 'userName', 'userID'));
    }
    
    
}
