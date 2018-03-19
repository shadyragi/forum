<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Reply;

class likescontroller extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth', ['only' => 'store']);
    }

    public function store(Reply $reply)
    {
    	if($reply->isLiked())
    	{
    		return;
    	}
    	
    	$reply->like();

    	return back();
    }
}
