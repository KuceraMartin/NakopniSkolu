<?php

namespace App\AdminModule\Presenters;


abstract class SecuredPresenter extends BasePresenter
{

	protected function startup()
	{
		parent::startup();

		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in', [
				'backlink' => $this->storeRequest()
			]);
		}
	}

}
