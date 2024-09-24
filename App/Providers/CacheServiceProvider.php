<?php

namespace App\Providers;

use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;

class CacheServiceProvider
{
  protected $cache;

  public function __construct()
  {
    $this->initCache();
  }

  protected function initCache()
  {
    // 创建服务容器
    $container = new Container();

    // 配置缓存设置
    $config = [
      'cache.default' => 'file', // 使用文件系统缓存
      'cache.stores.file' => [
        'driver' => 'file',
        'path' => __DIR__ . '/../../storage/cache/data', // 缓存路径
      ],
      'cache.prefix' => 'typecho_cache', // 缓存前缀
    ];

    // 将配置绑定到容器中
    $container->singleton('config', function () use ($config) {
      return new Config($config);
    });

    // 文件系统服务
    $container->singleton('files', function () {
      return new Filesystem();
    });

    // 创建 CacheManager
    $this->cache = new CacheManager($container);

    // 初始化缓存目录（如果不存在则创建）
    $cachePath = $config['cache.stores.file']['path'];
    if (!is_dir($cachePath)) {
      mkdir($cachePath, 0777, true);
    }
  }

  // 获取缓存实例
  public function getCache()
  {
    return $this->cache->store(); // 返回默认缓存存储实例
  }
}
