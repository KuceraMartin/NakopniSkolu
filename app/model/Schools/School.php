<?php

namespace App\Model;

use Nextras\Orm\Relationships\OneHasMany;


/**
 * @property string                 $name
 * @property string                 $email
 * @property string                 $password
 * @property string                 $phone
 * @property string                 $website
 * @property string                 $address
 * @property string                 $city
 * @property string                 $zip
 * @property Region                 $region {m:1 Region, oneSided=true}
 *
 * @property OneHasMany|Project[]   $projects {1:m Project::$school}
 */
class School extends Entity
{

}
