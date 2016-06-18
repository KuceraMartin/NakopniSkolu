<?php

namespace App\Model;


class ProjectsRepository extends Repository
{

	static function getEntityClassNames()
	{
		return [Project::class];
	}

}
