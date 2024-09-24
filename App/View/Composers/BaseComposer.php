<?php

namespace App\View\Composers;

use Utils\Helper;
use Illuminate\View\View;
use Typecho\Widget;

abstract class BaseComposer
{
  // 视图映射方法
  public static function views()
  {
    return ['*']; // 默认所有视图
  }

  // 定义 with() 接收一个 View 参数
  abstract public function with(View $view);

  public function compose(View $view)
  {
      // 获取当前 Typecho 页面上下文
      $archive = Widget::widget('\Widget\Archive');
      $user = Widget::widget('\Widget\User');
      $options = Widget::widget('\Widget\Options');
  
      // 将数据传递给视图
      $view->with(compact('archive', 'user', 'options'));
  
      // 处理额外的数据
      $data = $this->with($view);
      $view->with($data);
  }

  /**
   * 通用缓存方法，用于获取或存储缓存数据
   *
   * @param string $key 缓存键
   * @param int $duration 缓存时间（秒）
   * @param \Closure $callback 回调函数，如果缓存不存在时用于生成数据
   * @return mixed 缓存的数据
   */
  protected function getCachedData($key, $duration, \Closure $callback)
  {
    $cache = init_cache(); // 初始化缓存
    // ----------------------------------------
    // 判断是否为开发环境
    if (defined('APP_ENV') && APP_ENV === 'development') {
      // 开发环境，直接获取数据，不使用缓存
      // var_dump("跳过缓存: $key");
      return $callback();
    }

    // 调试 检查缓存是否存在
    if ($cache->has($key)) {
      // 缓存命中，输出调试信息
      var_dump("缓存命中: $key");
      return $cache->get($key);
    }

    // 缓存未命中，执行回调并存入缓存
    var_dump("缓存未命中: $key");
    $value = $callback();
    $cache->put($key, $value, $duration);

    return $value;

    // ----------------------------------------



    // 使用 remember 方法获取缓存数据
    // return $cache->remember($key, $duration, $callback);
  }
}
