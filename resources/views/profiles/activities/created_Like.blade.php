<div class="panel panel-default">
                <div class="panel-heading">{{$user->name}} Liked <a href="{{$activity->subject->reply->thread->path()}}">{{$activity->subject->reply->body}}</a> On 
                <a href="{{$activity->subject->reply->thread->path()}}">{{$activity->subject->reply->thread->title}}</a> {{$activity->subject->created_at->diffForHumans()}}</div>

			
                </div>
