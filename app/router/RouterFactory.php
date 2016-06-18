<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\SimpleRouter;


class RouterFactory
{

    /**
     * @return Nette\Application\IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList;
        $router[] = new Route('', 'Front:Homepage:default');
        $router[] = new Route('admin', 'Admin:Dashboard:default');
        $router[] = new SimpleRouter();

        return $router;
    }

}
