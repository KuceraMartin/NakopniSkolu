<?php

namespace App\AdminModule\Presenters;


use App\Model\Project;
use App\Model\ProjectsRepository;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;

class ProjectPresenter extends BasePresenter
{

	/** @var int @persistent */
	public $id;

	/** @var ProjectsRepository @inject */
	public $projects;

	/** @var Project */
	private $project;


	protected function startup()
	{
		parent::startup();

		$id = $this->getParameter('id');
		if ($id) {
			$this->project = $this->projects->getById($id);
			if (!$this->project) {
				throw new BadRequestException;
			}
		}
	}


	public function actionEdit()
	{
		if (!$this->project) {
			throw new BadRequestException;
		}
		$this['projectForm']->setDefaults($this->project->toArray());
	}

	public function renderEdit()
	{
		$this->template->project = $this->project;
		$this->setView('create');
	}

	protected function createComponentProjectForm(): Form
	{
		$form = new Form;

		$form->addText('name', 'Název projektu')
			->setRequired();

		$form->addTextArea('description', 'Popis')
			->setRequired();

		$form->addSubmit('submit');

		$form->onSuccess[] = function (Form $form) {
			$values = $form->values;

			if (!$this->project) {
				$this->project = new Project;
				$this->projects->attach($this->project);
			}
			$this->project->name = $values->name;
			$this->project->description = $values->description;
			$this->project->school = $this->user->id;
			$this->projects->persistAndFlush($this->project);

			$this->redirect('Dashboard:');
		};

		return $form;
	}

	public function handleRemove()
	{
		if ($this->project->isFunded()) {
			$this->flashMessage('Tento projekt právě někdo podpořil, a tak nemůže být smazán.', 'warning');
			$this->redirect('this');
		}
		$this->projects->remove($this->project);
		$this->projects->flush();
		$this->flashMessage('Projekt ' . $this->project->name . ' byl úspěšně odstraněn.', 'success');
		$this->redirect('Dashboard:default');
	}

}
