<?php

namespace App\Services;

use App\Model\SchoolsRepository;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\Passwords;


class Authenticator implements IAuthenticator
{

	/** @var SchoolsRepository */
	private $schools;


	public function __construct(SchoolsRepository $schools)
	{
		$this->schools = $schools;
	}


	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;
		$school = $this->schools->getBy(['email' => $email]);
		if (!$school) {
			throw new AuthenticationException("Uživatel s e-mailem '$email' nenalezen.");
		}

		if (!Passwords::verify($password, $school->password)) {
			throw new AuthenticationException('Zadali jste nesprávné heslo');
		}

		return new Identity($school->id);
	}

}
