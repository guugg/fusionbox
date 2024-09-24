<?php

// 加载 Composer 自动加载器
if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
  die('定位自动加载器时出错。请运行`composer install`.');
}

require $composer;

use App\Providers\BladeServiceProvider;





// 定义当前环境： 'development' 或 'production'
define('APP_ENV', 'development');  // 开发环境
define('APP_DEBUG', true);  // 设置为调试模式


function init_view()
{
  static $view = null;

  if (!$view) {
    $provider = new BladeServiceProvider();
    $view = $provider->getView();
  }

  return $view;
}
function init_cache()
{
    static $cache = null;

    if (!$cache) {
        $provider = new BladeServiceProvider();
        $cache = $provider->getCache(); // 获取缓存实例
    }

    return $cache;
}


// 自动加载 app 文件夹中的所有 PHP 文件
function load_app_files()
{
  $appDir = __DIR__ . '/app';

  if (is_dir($appDir)) {
    $files = glob($appDir . '/*.php');

    foreach ($files as $file) {
      require_once $file;
    }
  } else {
    error_log("App 文件夹不存在: " . $appDir);
  }
}

// 调用函数以加载文件
load_app_files();
