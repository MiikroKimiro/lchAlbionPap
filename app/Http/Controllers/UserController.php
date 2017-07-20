<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all()->toJson();
    }

    public function verify($id)
    {
        $user = User::find($id);
        if($user->verify)
        {
            $user->update(['verified' => 0]);
            return $user->name . ' is no more verified';

        }
        $user->update(['verified' => 1]);
        return $user->name . ' is verified';

    }

    public function isAdmin($id)
    {
        $user = User::find($id);
        if($user->isAdmin)
        {
            $user->update(['isAdmin' => 0]);
            return $user->name . ' is no more Admin';

        }
        $user->update(['isAdmin' => 1]);
        return $user->name . ' is Admin';
    }

    public function isOfficer($id)
    {
        $user = User::find($id);
        if($user->isOfficer)
        {
            $user->update(['isOfficer' => 0]);
            return $user->name . ' is no more Officer';
        }
        $user->update(['isOfficer' => 1]);
        return $user->name . ' is Officer';
    }
}
