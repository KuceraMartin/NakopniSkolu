<?php

namespace App\FrontModule\Presenters;

use App\Services\ImagePathGetter;
use Nette;
use App\Model\ProjectsRepository;


class HomepagePresenter extends BasePresenter
{

    /**
     * @inject
     * @var ProjectsRepository
     */
    public $projects;

    /** @var ImagePathGetter @inject */
    public $imagePathGetter;

    public function renderDefault()
    {
        $projects = $this->projects->findAll();
        $this->template->projects = $projects;

        $this->template->images = [];
        foreach ($projects as $project) {
            $this->template->images[$project->id] = $this->imagePathGetter->getPath($project);
        }
    }
}
