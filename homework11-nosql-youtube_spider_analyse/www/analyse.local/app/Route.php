<?php

namespace App;

use App\Controller\EventController;
use Klein\Klein;

/**
 * Class Route
 * @package App
 */
class Route
{
    /**
     * @var Klein
     */
    private $router;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->router = new Klein();
    }

    /**
     * @return void
     */
    public function init(): void
    {

        $this->router->respond('GET', '/events', static function ($request) {
            return (new EventController)->itemByParams($request);
        });

        $this->router->respond('POST', '/events/add', static function ($request) {
            return (new EventController)->add($request);
        });

        $this->router->respond('DELETE', '/events/delete', static function () {
            return (new EventController)->deleteAll();
        });

        $this->router->dispatch();
        
    }
}
