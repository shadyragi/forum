<div class="panel panel-default">
                <div class="panel-heading">{{$user->name}} Published <a href="{{$activity->subject->path()}}">{{$activity->subject->title}}</a> {{$activity->subject->created_at->diffForHumans()}}</div>

				<div class="panel-body">
               <a href="{{$activity->subject->path()}}"><h4>{{$activity->subject->title}}</h4></a>
                    <strong>{{$activity->subject->replies_count}} {{str_plural('reply', $activity->replies_count)}}</strong>
                    <div class="body">{{$activity->subject->body}}</div>
                </div>
                </div>
