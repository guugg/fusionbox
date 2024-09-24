<?php

namespace App\Providers;

use App\Providers\ViewServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\FilesystemServiceProvider;
use App\Providers\CacheServiceProvider;

class BladeServiceProvider
{
    protected $view;
    protected $cache; // 保存缓存实例

    public function __construct()
    {
        $this->initializeServices();
    }

    protected function initializeServices()
    {
        $filesystemProvider = new FilesystemServiceProvider();
        $filesystem = $filesystemProvider->getFilesystem();

        $container = new \Illuminate\Container\Container();
        $eventProvider = new EventServiceProvider($container);
        $dispatcher = $eventProvider->getDispatcher();

        $cacheProvider = new CacheServiceProvider();
        $this->cache = $cacheProvider->getCache(); // 保存缓存实例

        $viewProvider = new ViewServiceProvider($filesystem, $dispatcher, $this->cache);
        $this->view = $viewProvider->getView();
    }

    public function getView()
    {
        return $this->view;
    }

    public function getCache()
    {
        return $this->cache; // 返回缓存实例
    }
}
