@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Notifications</div>

             </div>
                @foreach($notifications as $notification)
                
               <div class="panel panel-default">
                <div class="panel-heading"> <a href="{{$notification->data['link']}}">{{$notification->data['message']}}</a> {{$notification->created_at->diffForHumans()}}</div>
                
                </div>

                @endforeach

        </div>
    </div>
</div>
@endsection
