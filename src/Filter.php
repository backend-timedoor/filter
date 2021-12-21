<?php

// credit : Om aleks

namespace Timedoor\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Filter
{
	protected $request;

	protected $query;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function apply(Builder $builder)
	{
		$this->query = $builder;

		foreach ($this->filters() as $name => $value) {
			$name  = Str::camel($name);

			$value = array_filter([$value], function ($value) {
				return ($value !== NULL && $value !== FALSE && $value !== '');
			});

			if (method_exists($this, $name) && $value) {
				call_user_func_array([$this, $name], $value);
			}
		}

		return $this->query;
	}

	public function filters()
	{
		return $this->request->all();
	}
}