<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Reply extends Model
{
    //
    use RecordActivity;

    protected $guarded = [];

    protected $with     = ['owner', 'likes'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($reply) {
            $reply->likes->each(function($like) {
                $like->delete();
            });
        });
    }

    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }


    public function likes()
    {
    	return $this->hasMany('App\like');
    }

    public function like()
    {
    	$this->likes()->create(['user_id' => Auth::id()]);
    }

    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function path()

    {
        return '/replies/' . $this->id;
    }



    public function getLikesCountAttribute()
    {
    	return $this->likes->count();
    }
    public function isLiked()
    {
    	if($result = $this->likes->where('user_id', Auth::id())->count())
    	{
    		return true;
    	}
    	return false;
    }

    public function mark()
    {
        $this->marked = 1;

        $this->save();
    }

    public function unmark()
    {
        $this->marked = 0;

        $this->save();
    }

    public function isMarked()
    {
        return $this->marked;
    }
}
