<?php

namespace App\Model;


/**
 * @method School getBy(array $conds)
 */
class SchoolsRepository extends Repository
{

	static function getEntityClassNames()
	{
		return [School::class];
	}

}
