<?php

namespace App\FrontModule\Presenters;

use Nette;
use App\Model\ProjectsRepository;


class HomepagePresenter extends BasePresenter
{

    /**
     * @inject
     * @var ProjectsRepository
     */
    public $projects;

    public function renderDefault()
    {
        $this->template->projects = $this->projects->findAll();
    }
}
