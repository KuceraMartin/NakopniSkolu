<?php

namespace App\AdminModule\Presenters;


use App\Model\ProjectsRepository;

class DashboardPresenter extends SecuredPresenter
{

	/** @var ProjectsRepository @inject */
	public $projects;

	public function renderDefault()
	{
		$this->template->projects = $this->projects->findBy(['school' => $this->user->id]);
	}

}
