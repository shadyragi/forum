@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
               

                @foreach($messages as $message)
                @if(session()->has($message))
                <div class="alert alert-success">
                    <strong>{{session($message)}}</strong>
                </div>  

                @endif

                @endforeach

                
              
                <div class="panel-heading">
                      @can('delete-thread', $thread)
                    <form action="/threads/{{$thread->id}}" method="POST">
                        {{method_field('DELETE')}}
                        {{csrf_field()}}
                        <button style="float:right;" name="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endcan


                <a href="/profiles/{{$thread->owner->name}}">{{$thread->owner->name}}</a> said {{$thread->title}} {{$thread->created_at->diffForHumans()}} - <strong>{{$visits}} visits</strong>

                </div>
                
                <div class="panel-body">
                       {{$thread->body}}
                </div>
            </div>
             @foreach($replies as $reply)

                <div class="panel panel-default">

                <div class="panel-heading"> <a href="/profiles/{{$reply->owner->name}}">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}

                 @if($reply->isMarked())
                 @can('mark-reply', $thread)
                    <div style="float: right;">
                    <form method="POST" action="{{$reply->path()}}/unmark">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                    <button  class="btn btn-success">UnMark</button>
                    </form>
                     </div>
                     @endcan
                 @endif   

                 <div style="float:right;">
                    <form method="POST" action="/replies/{{$reply->id}}/like">
                        {{csrf_field()}}
                        <button class="btn btn-primary" {{$reply->isLiked() ? 'disabled' : ''}}>
                            {{$reply->likes_count}}
                            Like
                        </button>
                    </form>
                </div>
                @can('update-reply', $reply)
                  <div style="float:right;">
                    <form method="POST" action="{{route('delete_reply', ['reply' => $reply->id])}}">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <button class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </div>
                <div style="float:right;">
                    <a href="{{route('edit_reply', ['reply' => $reply->id])}}" class="btn btn-default">Edit</a>

                </div>

                @endcan

                @can('mark-reply', $thread)
                @unless($thread->hasMarkedReply())
                <div style="float:right;">
                    <form method="POST" action="{{route('mark-reply', ['reply' => $reply->id])}}">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <button class="btn btn-success">
                            Mark Reply As The Best
                        </button>
                    </form>
                </div>
                @endunless

                @endcan

                </div>   

               

                <div class="panel-body">
                       {{$reply->body}}
                </div>
                </div>
                <hr>

             @endforeach

             {{$replies->links()}}


             @if(auth()->check())
             <form method="POST" action="{{route('add_reply', ['channel' => $thread->channel->slug  ,'thread' => $thread->id])}}">
                 {{csrf_field()}}
                 <textarea class="form-control" class="body" name="body" id="body" rows="5" placeholder="Leave Reply"></textarea>
                 <input type="submit" name="submit" class="btn btn_default">
             </form>
             @else
             <p>You Should <a href="/login">SignIn</a> To Leave A Comment</p>
             @endif
        </div>
           <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="#">{{$thread->owner->name}}</a> said {{$thread->title}} {{$thread->created_at->diffForHumans()}}</div>

                <div class="panel-body">
                       <p>This Post Created By <a href="#">{{$thread->owner->name}}</a> {{$thread->created_at->diffForHumans()}}  And It Has 
                       {{$thread->replies_count}} {{str_plural('comment', $thread->replies_count)}}
                       </p>

                       <p>
                            <form method="POST" action="{{$thread->path()}}/subscriptions">
                            {{csrf_field()}}
                            @if($thread->isSubscribed())
                            {{method_field('DELETE')}}
                            <button class="btn btn-danger">Unsubscribe</button>
                            @else
                            <button class="btn btn-primary">Subscribe</button> 
                            @endif
                            </form>
                       </p>
                </div>
            </div>
      </div>
    </div>
     

          
           
    </div>

@endsection
