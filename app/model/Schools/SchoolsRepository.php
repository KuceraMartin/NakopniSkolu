<?php

namespace App\Model;


class SchoolsRepository extends Repository
{

	static function getEntityClassNames()
	{
		return [School::class];
	}

}
