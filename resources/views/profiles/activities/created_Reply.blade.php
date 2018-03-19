<div class="panel panel-default">
                <div class="panel-heading">{{$user->name}} Replied To <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a> {{$activity->subject->created_at->diffForHumans()}}</div>

				<div class="panel-body">
             
                    	
                    <div class="body">{{$activity->subject->body}}</div>
                </div>
                </div>
