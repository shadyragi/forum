<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reply;

use App\Notifications\replyMarked;

use App\Http\Requests;

class markReplyController extends Controller
{
    //
    public function store(Reply $reply)
    {
        $this->authorize('mark-reply', $reply->thread);

        $reply->mark();

        $reply->owner->notify(new replyMarked($reply));

        return back();
    }

    public function destroy(Reply $reply)
    {
    	$this->authorize('mark-reply', $reply->thread);

    	$reply->unmark();

    	return back();
    }
}
