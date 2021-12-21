# Query Filter 

## Installation

```
$ composer require timedoor/filter
```

## Usage

```
$ php artisan make:filter --model={model}
```
This command will create new file inside app/Http/Filter and the file name depends on model name

After that you must use filter trait in your model
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Timedoor\Filter\FilterTrait;

class Foo extends Model
{
	use  FilterTrait;
}
```

Now you can filter data using filter method

```
<?php

namespace App\Http\Controllers;

use App\Models\Foo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class  AdminController  extends  Controller
{
	public  function  index(Request  $request)
	{
		$foo = Foo::filter($request)->get();
	}
}
```