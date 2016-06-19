<?php

namespace App\AdminModule\Presenters;


use App\Model\ProjectsRepository;
use App\Services\ImagePathGetter;

class DashboardPresenter extends SecuredPresenter
{

	/** @var ProjectsRepository @inject */
	public $projects;

	/** @var ImagePathGetter @inject */
	public $imagePathGetter;

	public function renderDefault()
	{
		$projects = $this->projects->findBy(['school' => $this->user->id]);
		$this->template->projects = $projects;

		$this->template->images = [];
		foreach ($projects as $project) {
			$this->template->images[$project->id] = $this->imagePathGetter->getPath($project);
		}
	}

}
