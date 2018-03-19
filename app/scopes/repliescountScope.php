<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\scope;

class repliescountScope implements scope
{
	public function apply(Builder $Builder, Model $model)
	{
		return $Builder->withCount('replies');
	}
}



?>