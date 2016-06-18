<?php

namespace App\AdminModule\Presenters;


use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\Passwords;

class SignPresenter extends BasePresenter
{

	public function actionOut()
	{
		$this->user->logout();
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

}
