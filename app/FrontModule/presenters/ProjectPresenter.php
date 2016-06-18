<?php

namespace App\FrontModule\Presenters;

use Nette;
use App\Model\ProjectsRepository;


class ProjectPresenter extends BasePresenter
{

    /**
     * @inject
     * @var ProjectsRepository
     */
    public $projects;

    /**
     * @param $id
     */
    public function renderDetail($id)
    {
        $this->template->project = $this->projects->getById($id);
    }
}
