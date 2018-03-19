<?php

namespace App\Filters;

use Illuminate\Http\Request;


class Filters
{
	protected $request;
	protected $builder;
	protected $filters = [];
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}


	public function apply($builder)
	{
		$this->builder = $builder;

	
		foreach ($this->getFilters() as $filter => $value) {
					# code...
			$this->$filter($value);

			}

		return $builder;

	}
		
		
	

	private function getFilters()
	{
		return $this->request->intersect($this->filters);
	}
}

?>