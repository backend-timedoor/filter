<?php

namespace Timedoor\Filter;

use ReflectionClass;

trait FilterTrait
{
	protected $request;

	public function scopeFilter($query, $request)
	{
		$filter = $this->getFilterClass($request);

	    return $filter->apply($query);
	}

	protected function getFilterClass($request)
	{
		$reflect     = new ReflectionClass(get_class());
		$class       = $reflect->getShortName() . config('filter.suffix');

		$filterClass = 'App\\Http\\Filter\\' . $class;

		if (class_exists($filterClass)) return new $filterClass($request);

		abort(500, "Filter class not found");
	}
}