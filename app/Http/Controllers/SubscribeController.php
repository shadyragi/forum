<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Subscribe;

use App\Thread;

class SubscribeController extends Controller
{
    //

    public function store($channelId, Thread $thread)
    {
    	$thread->subscribe();

    	return back()->with('subscribed', 'You Subscribed Successfully To This Thread');
    }

    public function destroy($channelId, Thread $thread)
    {
    	$thread->unSubscribe();

    	return back()->with('unsubscribed', 'You unSubscribed From This Thread');
    }
}
