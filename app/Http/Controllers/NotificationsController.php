<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Reply;

class NotificationsController extends Controller
{
    //

    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {

    	$notifications = Auth()->user()->unReadNotifications;

    	$replies = [];

    	

    	return view('notifications.index',compact('notifications'));
    	
    }
}
