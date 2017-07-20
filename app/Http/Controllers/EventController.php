<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'type'  => 'required'
        ]);

        $user = Auth::user();
        $event = Event::create([
            'lead_id' => $user->id,
            'name'      => $request->name,
            'type'      => $request->type,
            'comment'   => $request->comment,
            'hashed_id' => hash('md2', Carbon::now()->toDateTimeString())
        ]);

        $event->participants()->attach([
            'user_id'   => $user->id
        ]);

        return $event->pap_link;
    }

    public function registerPap($hashedId)
    {
        $event = Event::where('hashed_id', $hashedId)->first();
        $user = Auth::user();
        if($event->status == 'open') {
            if($event->participants()->where('user_id', $user->id)->get()->isEmpty()) {
                $attach = $event->participants()->attach($user->id);
                if ($attach == null) {
                    $papResponse = 'Participation registered';
                } else {
                    $papResponse = 'Participation not registered';
                }
            } else {
                $papResponse = 'Participation already registered';
            }
        } else {
            $papResponse = 'Event closed';
        }

        return view('events.pap', compact('papResponse'));
    }

    public function index()
    {
        $events = Event::thisMonth()
            ->orderByDesc('created_at')
            ->withCount('participants')
            ->get()->toJson();

        $thisMonthBad = User::withCount('thisMonthParticipations')
            ->orderBy('this_month_participations_count', 'asc')
            ->take(3)->get()->toJson();

        $lastMonthBad = User::withCount('lastMonthParticipations')
            ->orderBy('last_month_participations_count', 'asc')
            ->take(3)->get()->toJson();

        return ['events' => $events, 'thisMonthBad' => $thisMonthBad, 'lastMonthBad' => $lastMonthBad];
    }
}
