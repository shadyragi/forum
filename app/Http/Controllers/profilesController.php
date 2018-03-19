<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class profilesController extends Controller
{
    //
    public function show(User $user)
    {
    	$activities = $this->getActivity($user);
    
    	return view('profiles.show', ['user' => $user, 'activities' => $activities]);
    }

    private function getActivity(User $user)
    {
    	return $user->activity()->with('subject')->latest()->get()->groupBy( function($activity) {
    			return $activity->created_at->format('D');
    	});

    }
}
