<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

class EventServiceProvider
{
    protected $dispatcher;

    public function __construct(Container $container)
    {
        $this->dispatcher = new Dispatcher($container);
    }

    public function getDispatcher()
    {
        return $this->dispatcher;
    }
}
