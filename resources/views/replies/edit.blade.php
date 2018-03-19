@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Reply On <a href="{{$reply->thread->path()}}">{{$reply->thread->title}}</a></div>

                <div class="panel-body">
                    <form method="POST" class="form-group" action="{{route('update_reply', ['reply' => $reply->id])}}">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <textarea name="body" rows="8" class="form-control">
                             {{trim($reply->body)}}
                    </textarea>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update Reply">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
