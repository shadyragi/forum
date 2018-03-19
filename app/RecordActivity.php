<?php

namespace App;

use Auth;

trait RecordActivity
{
	protected static function bootRecordActivity()
	{
		foreach(static::getEvents() as $event)
		{
			 static::$event( function ($model) use ($event) {
	            $model->record($event);
	        });

			 static::deleting( function($model) {
			 	$model->activity()->delete();
			 });
		}
	}

	public static function getEvents()
	{
		return ['created'];
	}

	public function record($event)
	{
		$this->activity()->create([
				'user_id' => Auth::id(),
				'type'    => $this->getShortName($event)
			]);

		
	}

	public function activity()
	{
		return $this->morphMany('App\Activity', 'subject');
	}

	private function getShortName($event)
	{
		return $event . '_' . (new \ReflectionClass($this))->getShortName();
	}


}


?>