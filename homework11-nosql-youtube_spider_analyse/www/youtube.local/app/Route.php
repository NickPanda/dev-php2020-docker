<?php

namespace App;

use App\Controller\ChannelController;
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

        $this->router->respond('GET', '/spider', static function () {
            return (new ChannelController())->spider();
        });

        $this->router->respond('GET', '/top-channels', static function ($request) {
            return (new ChannelController)->topChannels($request);
        });

        $this->router->respond('GET', '/statistics-channel-videos', static function ($request) {
            return (new ChannelController)->statisticsChannelVideos();
        });

        $this->router->respond('DELETE', '/channels', static function () {
            return (new ChannelController)->deleteChannels();
        });

        $this->router->dispatch();
        
    }
}
