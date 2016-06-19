<?php

namespace App\FrontModule\Forms;

use App\Model\ProjectsRepository;
use App\Model\Reservation;
use Nette;
use Nette\Application\UI\Form;
use App\Model\ReservationsRepository;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nextras\Dbal\UniqueConstraintViolationException;


class ReservationFormFactory extends Nette\Object
{
    /**
     * @var ReservationsRepository
     */
    protected $reservations;

    /**
     * @var string
     */
    protected $senderEmail;

    /**
     * @var IMailer $mailer
     */
    protected $mailer;

    /**
     * @var ProjectsRepository $projects
     */
    protected $projects;


    /**
     * ReservationFormFactory constructor.
     * @param string $senderEmail
     * @param ReservationsRepository $reservations
     * @param ProjectsRepository $projects
     * @param IMailer $mailer
     */
    public function __construct(string $senderEmail, ReservationsRepository $reservations, ProjectsRepository $projects, IMailer $mailer)
    {
        $this->senderEmail = $senderEmail;
        $this->reservations = $reservations;
        $this->projects = $projects;
        $this->mailer = $mailer;
    }

    /**
     * @return Form
     */
    public function create($id)
    {
        $form = new Form;
        $form->addHidden('project_id')
            ->setValue($id);
        $form->addText('full_name', 'Celé jméno')
            ->setRequired('Musíte vyplnit své jméno.');
        $form->addText('email', 'E-mail')
            ->setRequired('Musíte vyplnit svůj e-mail.')
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
        $reservation = new Reservation();
        $this->reservations->attach($reservation);
        $reservation->fullName = $values->full_name;
        $reservation->email = $values->email;
        $reservation->project = $values->project_id;
        try {
            $this->reservations->persistAndFlush($reservation);
        } catch (UniqueConstraintViolationException $e) {
            $form->addError('Tento projekt už byl podpořen někým jiným. Omlouváme se.');
        }

        $this->sendNotificationEmailToFunder($values);
        $this->sendNotificationEmailToSchool($values);
    }

    /**
     * @param $values
     */
    public function sendNotificationEmailToFunder($values)
    {
        $mail = new Message();
        $mail->setFrom($this->senderEmail)
            ->addTo($values->email)
            ->setSubject('Počítáme s vámi!')
            ->setBody('404 body not found. YET!');
        $this->send($mail);
    }

    /**
     * @param $values
     */
    public function sendNotificationEmailToSchool($values)
    {
        $mail = new Message();
        $mail->setFrom($this->senderEmail)
            ->addTo($this->projects->getById($values->project_id)->school->email)
            ->setSubject('Našli jsme Vám patrona!')
            ->setBody('404 body not found. YET!');
        $this->send($mail);
    }

    /**
     * @param $email
     */
    public function send($email)
    {
        $this->mailer->send($email);
    }
}