<?php

namespace App\FrontModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\FrontModule\Forms\SubscriptionFormFactory;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @inject
     * @var SubscriptionFormFactory
     */
    public $subscriptionFormFactory;

    /**
     * @return Form
     */
    protected function createComponentSubscriptionForm()
    {
        $form = $this->subscriptionFormFactory->create();
        $form->onSuccess[] = function (Form $form) {
            $this->flashMessage('Děkujeme! Budeme Vás informovat o dalších změnách.', 'success');
            $this->redirect('this');
        };

        return $form;
    }
}
