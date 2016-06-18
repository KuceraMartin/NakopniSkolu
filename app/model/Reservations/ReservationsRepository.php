<?php

namespace App\Model;


class ReservationsRepository extends Repository
{

	static function getEntityClassNames()
	{
		return [Reservation::class];
	}

}
