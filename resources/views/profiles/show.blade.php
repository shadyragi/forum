@extends('layouts.app')

@section('content')
<div class="container">
        <div class="page-header">
            @unless(empty($user->avatar_path))
            <img src="/{{$user->avatar_path}}" class="img-rounded" alt="error" width="304" height="236">
            @endunless
            <h2>
                {{$user->name}}
                <small>Signed Up {{$user->created_at->diffForHumans()}}</small>
            </h2>
            @can('upload-photo', $user)
            <form method="POST" action="{{route('upload-image', ['user' => $user->id])}}" enctype="multipart/form-data">
                {{csrf_field()}}

            <input type="submit" name="submit" value="Upload Photo" style="float: left;" class="btn btn-primary">

            <input style="float: left; margin: 10px;" type="file" name="avatar">

            </form>
            @if($errors->has('avatar'))
            @foreach($errors->all() as $error)
            <div style="clear: both;" class="alert alert-danger">{{$error}}</div>
            @endforeach
            @endif
            @endcan


        </div>
           

                <div class="panel-body">
                    @foreach($activities as $date => $activity)
                    <h3 class="page-header">{{$date}}</h3>
                    @foreach($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                      <hr>
                    @endforeach
                    
                  
                    @endforeach
                </div>
            
</div>
@endsection
