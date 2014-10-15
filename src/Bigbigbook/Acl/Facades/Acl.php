<?php
namespace Bigbigbook\Acl\Facades;

use Illuminate\Support\Facades\Facade;

class Acl extends Facade
{
    protected static function getFacadeAccessor()
	{
		return 'acl';
	}
}