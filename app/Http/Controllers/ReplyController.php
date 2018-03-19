<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Thread;

use App\Reply;

use App\Notifications\replyMarked;

use Auth;
class ReplyController extends Controller
{
    //

    public function store($channelId, Thread $thread)
    {
    	$reply = $thread->replies()->create([
    		'body'    => request('body'),
    		'user_id' => Auth::id()
    		]);

       

        $thread->notifySubscriptions($reply);

    	return back();
    }

    public function edit(Reply $reply)
    {
    	return view('replies.edit', ['reply' => $reply]);
    }

    public function update(Request $request, Reply $reply)
    {
    	if($request->user()->can('update-reply', $reply))
    	{

    		$reply->body = request('body');

    		$reply->save();

    		return redirect($reply->thread->path())->with('reply-updated', 'Reply Has Been Updated Successfully');
    	}
    }

    public function destroy(Request $request, Reply $reply)
    {

    	if($request->user()->can('update-reply', $reply))
    	{
    		
    		$reply->delete();

    		return back();
    	}
    }

    
}
