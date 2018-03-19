<?php

namespace App\Filters;

use App\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;



class ThreadFilters extends Filters
{
	/*protected $request;
	protected $builder;

	protected $filters = ['by'];
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}


	public function apply($builder)
	{
		$this->builder = $builder;

		if($name = $this->request->by)
		{
			return $this->byUser($name);
		}

		return $builder;
	}*/
	protected $filters = ['by', 'popular', 'trending'];

	public function by($name)
	{
	

			$user = User::where('name', $name)->firstOrFail();

			return $this->builder->where('user_id', $user->id);
	}

	public function popular()
	{
		//empty orders in the builder to override it with orderBy

		$this->builder->getQuery()->orders = [];
		
		return $this->builder->has('replies', '>', '1')->orderBy('replies_count', 'desc');
	}

	public function trending()
	{
		$threadIds = Redis::zrevrange('threads', 0, 2);

		$this->builder->whereIn('id', $threadIds);
	}
}

?>