<?php

namespace App\FrontModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\ProjectsRepository;
use App\FrontModule\Forms\ReservationFormFactory;


class ProjectPresenter extends BasePresenter
{

    /**
     * @inject
     * @var ProjectsRepository
     */
    public $projects;

    /**
     * @inject
     * @var ReservationFormFactory
     */
    public $reservationFormFactory;

    /**
     * @param $id
     */
    public function renderDetail($id)
    {
        $project = $this->projects->getById($id);
        if (!$project) {
            $this->error('Projekt nebyl nalezen.', 404);
        }
        $this->template->project = $project;
    }

    /**
     * @return Form
     */
    protected function createComponentReservationForm()
    {
        $form = $this->reservationFormFactory->create($this->getParameter('id'));
        $form->onSuccess[] = function (Form $form) {
            $this->flashMessage('Děkujeme! Odeslali jsme Vám e-mail, kde naleznete všechny potřebné informace.', 'success');
            $this->redirect('this');
        };

        return $form;
    }
}
