<?php

namespace App\FrontModule\Forms;

use App\Model\Subscription;
use Nette;
use Nette\Application\UI\Form;
use App\Model\SubscriptionsRepository;


class SubscriptionFormFactory extends Nette\Object
{
    /**
     * @var SubscriptionsRepository
     */
    protected $subscriptions;

    /**
     * @param SubscriptionsRepository $subscriptions
     */
    public function __construct(SubscriptionsRepository $subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * @return Form
     */
    public function create()
    {
        $form = new Form;
        $form->addText('email')
            ->setRequired()
            ->addRule(Form::EMAIL, 'E-mailová adresa musí být ve formátu jan.novak@gmail.com.');

        $form->addSubmit('send', 'Odeslat');
        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    /**
     * @param Form $form
     * @param $values
     */
    public function processForm(Form $form, $values)
    {
        $subscription = new Subscription();
        $subscription->email = $values->email;
        $this->subscriptions->persistAndFlush($subscription);
    }
}