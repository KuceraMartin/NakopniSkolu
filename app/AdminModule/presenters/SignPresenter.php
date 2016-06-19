<?php

namespace App\AdminModule\Presenters;


use App\Model\RegionsRepository;
use App\Model\School;
use App\Model\SchoolsRepository;
use Nette\Application\UI\Form;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Security\AuthenticationException;


class SignPresenter extends BasePresenter
{

	/** @var RegionsRepository @inject */
	public $regions;

	/** @var SchoolsRepository @inject */
	public $schools;

	/** @var IMailer @inject */
	public $mailer;

	public function actionOut()
	{
		$this->user->logout();
		$this->redirect('in');
	}

	protected function createComponentSignInForm(): Form
	{
		$form = new Form;

		$form->addText('email', 'E-mail')
			->setRequired()
			->addRule(Form::EMAIL);

		$form->addPassword('password', 'Heslo')
			->setRequired();

		$form->addSubmit('submit');

		$form->onSuccess[] = function (Form $form) {
			$values = $form->values;
			try {
				$this->user->login($values->email, $values->password);
			} catch (AuthenticationException $e) {
				$form->addError($e->getMessage());
				return;
			}

			$backLink = $this->getParameter('backlink');
			if ($backLink) {
				$this->restoreRequest($backLink);
			}
			$this->redirect('Dashboard:');
		};

		return $form;
	}

	protected function createComponentRegisterForm(): Form
	{
		$form = new Form;

		$form->addText('name', 'Název školy')
			->setRequired();

		$form->addSelect('region', 'Kraj')
			->setItems($this->regions->findAll()->fetchPairs('id', 'name'));

		$form->addText('city', 'Město')
			->setRequired();

		$form->addText('zip', 'PSČ')
			->setRequired();

		$form->addText('address', 'Ulice a číslo popisné')
			->setRequired();

		$form->addText('email', 'Kontaktní e-mail')
			->setRequired()
			->addRule(Form::EMAIL);

		$form->addText('phone', 'Telefon')
			->setRequired();

		$form->addText('website', 'Web školy')
			->setRequired()
			->addRule(Form::URL);

		$form->addSubmit('submit');

		$form->onSuccess[] = function (Form $form) {
			$values = $form->values;

			$school = new School;
			$this->schools->attach($school);
			foreach ($values as $key => $value) {
				$school->setValue($key, $value);
			}
			$this->schools->persistAndFlush($school);

			$message = new Message;
			$message->setFrom($values->email);
			$message->addTo($this->context->parameters['senderEmail']);
			$message->setSubject('žádost o registraci školy');
			$message->setBody("$school->name, #$school->id");
			$this->mailer->send($message);

			$this->flashMessage('Děkujeme za zájem, co nejdříve se vám ozveme!');
			$this->redirect('this');
		};

		return $form;
	}

}
