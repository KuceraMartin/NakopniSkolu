<?php

namespace App\AdminModule\Presenters;


use App\Model\Project;
use App\Model\ProjectsRepository;
use App\Services\ImagePathGetter;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\Utils\Image;

class ProjectPresenter extends BasePresenter
{

	const IMAGE_RESOLUTION = ['width' => 360, 'height' => 180];

	/** @var int @persistent */
	public $id;

	/** @var ProjectsRepository @inject */
	public $projects;

	/** @var ImagePathGetter @inject */
	public $imagePathGetter;

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
		$this->template->image = $this->imagePathGetter->getPath($this->project);
		$this->setView('create');
	}

	protected function createComponentProjectForm(): Form
	{
		$form = new Form;

		$form->addText('name', 'Název projektu')
			->setRequired();

		$form->addTextArea('description', 'Popis')
			->setRequired();

		$form->addUpload('image', 'Obrázek')
			->addCondition(Form::FILLED)
			->addRule(Form::IMAGE);

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

			/** @var FileUpload $imageUpload */
			$imageUpload = $values->image;
			if ($imageUpload->isOk()) {
				$image = $imageUpload->toImage();
				$image->resize(self::IMAGE_RESOLUTION['width'], self::IMAGE_RESOLUTION['height'], Image::FILL);
				$left = ($image->width - self::IMAGE_RESOLUTION['width']) / 2;
				$top = ($image->height - self::IMAGE_RESOLUTION['height']) / 2;
				$image->crop($left, $top, self::IMAGE_RESOLUTION['width'], self::IMAGE_RESOLUTION['height']);
				$image->save($this->imagePathGetter->constructPath($this->project));
			}

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
