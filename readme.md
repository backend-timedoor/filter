# Query Filter 

## Installation

```
$ composer require timedoor/filter
```

## Usage

```
$ php artisan make:filter {name}
$ php artisan make:filter UserFilter // example
```
This command will create new file inside app/Http/Filter and the file name depends on model name

After that you need use filter trait in your model
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Timedoor\Filter\FilterTrait;

class Foo extends Model
{
	use FilterTrait;
}
```
By default this trait will execute filter class depends on model name
for example if you use User model and create UserFilter you don't need to specify the filter class in the model.

You can set $filterClass property to specify filter you want to use 
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Timedoor\Filter\FilterTrait;
use App\Http\Filter\OtherFilter;

class Foo extends Model
{
	use FilterTrait;
	
	protected $filterClass = OtherFilter::class;
}
```


Now you can filter data using filter method

```
<?php

namespace App\Http\Controllers;

use App\Models\Foo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	public function index()
	{
		$foo = Foo::filter()->get();
	}
}
```
You also can pass $request parameter to filter method, but it's optional

## Thank you