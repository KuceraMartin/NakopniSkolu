<?php

namespace App\Model;


class SubscriptionsRepository extends Repository
{

    static function getEntityClassNames()
    {
        return [Subscription::class];
    }

}
