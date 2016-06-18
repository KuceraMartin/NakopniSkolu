<?php

namespace App\Model;


class RegionsRepository extends Repository
{

	static function getEntityClassNames()
	{
		return [Region::class];
	}

}
