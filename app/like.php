<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    //
	use RecordActivity;

    protected $fillable = ['user_id', 'reply_id'];

    public function reply()
    {
    	return $this->belongsTo('App\Reply');
    }
}
