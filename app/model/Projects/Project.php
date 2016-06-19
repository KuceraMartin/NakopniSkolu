<?php

namespace App\Model;


/**
 * @property string            $name
 * @property string            $description
 * @property School            $school {m:1 School::$projects}
 * @property Reservation|NULL  $reservation {1:1 Reservation::$project}
 */
class Project extends Entity
{

    public function isFunded()
    {
        return $this->reservation !== NULL;
    }

}
