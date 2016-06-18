<?php

namespace App;

use Nette;
use Nette\Application\IRouter;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

    /**
     * @return IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList;

        //Admin
        $router[] = new Route('admin/<presenter>/<action>/<id>', [
            'module' => 'Admin',
            'presenter' => 'Dashboard',
            'action' => 'default',
            'id' => NULL
        ]);

        //Front
        $router[] = new Route('<presenter>/<action>/<id>', [
            'module' => 'Front',
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => NULL
        ]);

        return $router;
    }

}
