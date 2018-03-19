<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Thread;

use App\Channel;

use App\User;

use App\Filters\ThreadFilters;

use Illuminate\Support\Facades\Redis;

use Auth;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //protected $fillable = ['title', 'body', 'user_id'];

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Channel $channel, ThreadFilters $filters)
    {


            if($channel->exists)
            {
                $threads = $channel->threads()->latest();
            }
            else {

                $threads = Thread::latest();
            }        
        
        $threads = $threads->filter($filters)->get();

        return view('threads.index', ['threads' => $threads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'title' => 'required|max:20',
            'body'  => 'required',
            'channel_id' => 'required|exists:channels,id'
            ]);

        $thread = Thread::create([
            'channel_id' => request('channel_id'),
            'user_id' => Auth::id(),
            'title' => request('title'),
            'body'  => request('body')
            ]);

        return redirect($thread->path())->with('thread_created', 'Thread Has Been Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($channelid, Thread $thread)
    {
        //
        $visits = Redis::zincrBy('threads', 1, $thread->id);

        $successMessages = ['thread_created', 'reply-updated', 'subscribed', 'unsubscribed'];

       return view('threads.show', [
        'thread' => $thread,
        'replies' => $thread->replies()->paginate(10),
        'visits'  => $visits,
        'messages' => $successMessages
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        dd('test');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $thread = Thread::find($id);

        if(Auth::user()->isAuthorizedToDeleteThread($thread))
        {
            Thread::destroy($id);
        }
     

        return redirect('/threads?by='.Auth::user()->name)->with('thread_deleted', 'Thread Has Been Deleted Successfully');
    }



   
}
