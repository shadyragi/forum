<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    //
    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function threads()
    {
    	return $this->hasMany('App\Thread')
                    ->with('channel');
    }
    public function path()
    {
    	return '/threads/'.$this->slug. '/';
    }
}
