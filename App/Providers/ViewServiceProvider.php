<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\View\Engines\EngineResolver;
use App\View\Composers\App;
use App\View\Composers\Post;
use App\View\Composers\PageNav;
use App\View\Composers\Comments;
use Illuminate\Cache\Repository as Cache;  // 使用缓存
use Typecho\Widget;

class ViewServiceProvider
{
  protected $view;
  protected $cache;  // 缓存服务

  public function __construct(Filesystem $filesystem, Dispatcher $dispatcher, Cache $cache)
  {
    $this->cache = $cache;
    $this->initView($filesystem, $dispatcher);
  }

  protected function initView(Filesystem $filesystem, Dispatcher $dispatcher)
  {
    $views = __DIR__ . '/../../resources/views';
    $cachePath = __DIR__ . '/../../storage/cache';

    $resolver = new EngineResolver;

    // 初始化 Blade 编译器，并使用缓存路径
    $bladeCompiler = new BladeCompiler($filesystem, $cachePath);

    $resolver->register('blade', function () use ($bladeCompiler) {
      return new CompilerEngine($bladeCompiler);
    });

    $resolver->register('php', function () use ($filesystem) {
      return new \Illuminate\View\Engines\PhpEngine($filesystem);
    });

    $viewFinder = new FileViewFinder($filesystem, [$views]);
    $this->view = new Factory($resolver, $viewFinder, $dispatcher);

    $this->view->addExtension('blade.php', 'blade');

    // 注册视图 Composer
    $this->registerComposers();
  }

  protected function registerComposers()
  {
    // 将 $archive 传递到所有视图
    // $this->view->composer('*', function ($view) {
    //   // 获取当前 Typecho 页面上下文
    //   $fbox = Widget::widget('\Widget\Archive');
    //   $user = Widget::widget('\Widget\User');
    //   $options = Widget::widget('\Widget\Options');
  
    //   // 将数据传递给视图
    //   $view->with(compact('fbox', 'user', 'options'));
    // });

    $composers = [
      App::class,
      Post::class,
      PageNav::class,
      Comments::class,
    ];

    foreach ($composers as $composerClass) {
      if (class_exists($composerClass)) {
        $composer = new $composerClass();

        foreach ($composer::views() as $viewName) {
          // 使用视图工厂的 `composer` 方法绑定视图
          $this->view->composer($viewName, function ($view) use ($composer) {
            $composer->compose($view);
          });
        }
      }
    }
  }

  public function getView()
  {
    return $this->view;
  }
}
