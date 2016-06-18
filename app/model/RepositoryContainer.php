<?php

namespace App\Model;

use Nextras\Orm;


/**
 * @property-read ProjectsRepository         $projects
 * @property-read RegionsRepository          $regions
 * @property-read ReservationsRepository     $reservations
 * @property-read SchoolsRepository          $schools
 * @property-read SubscriptionsRepository    $subscriptions
 */
class RepositoryContainer extends Orm\Model\Model
{

}
