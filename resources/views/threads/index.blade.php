@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if(session('thread_deleted'))
                <div class="alert alert-success">
                  <strong>{{session('thread_deleted')}}</strong> 
                </div>
                @endif
                <div class="panel-heading">Threads</div>

                <div class="panel-body">
                    @foreach($threads as $thread)
                      @can('delete-thread', $thread)
                    <form action="/threads/{{$thread->id}}" method="POST">
                        {{method_field('DELETE')}}
                        {{csrf_field()}}
                        <button style="float:right;" name="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endcan

                    <a href="{{$thread->path()}}"><h4>{{$thread->title}}</h4></a>

                    <strong>{{$thread->replies_count}} {{str_plural('reply', $thread->replies_count)}}</strong>
                   
                    <div class="body">{{$thread->body}}</div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
