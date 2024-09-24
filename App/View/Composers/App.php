<?php

namespace App\View\Composers;

use Utils\Helper;

class App extends BaseComposer
{
  public static function views()
  {
    return [
      '*', // 指定视图
      // 其他视图
    ];
  }

  public function with($view)
  {
    return [
      'siteName' => $this->getSiteName(),
    ];
  }

  protected function getSiteName()
  {
    // 调用 BaseComposer 中的 getCachedData 方法，减少代码量
    return $this->getCachedData('site_name', 3600, function () {
      return Helper::options()->title; // 获取站点名称
    });
  }
}
