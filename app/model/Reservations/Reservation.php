<?php


namespace App\Model;


/**
 * @property string            $fullName
 * @property string            $email
 * @property Project           $project {1:1 Project::$reservation, isMain=true}
 */
class Reservation extends Entity
{

}
