<?php

namespace App\Model;

use DateTime;
use Nextras\Orm;


/**
 * @property-read int $id {primary}
 * @property DateTime $createdAt {default now}
 */
abstract class Entity extends Orm\Entity\Entity
{

}
