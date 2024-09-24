<?php

namespace App;

use Illuminate\Container\Container;

class AppContainer extends Container
{
  protected $bindings = [];

  public function __construct()
  {
    parent::__construct();

    // 绑定 Blade 工厂
    $this->bind('sage.view', function () {
      global $bladeFactory;
      return $bladeFactory;
    });

    // 绑定数据
    $this->bind('sage.data', function () {
      return [];
    });
  }

  public function setData(array $data)
  {
    $this->instance('sage.data', $data);
  }
}

// 创建全局容器实例
$container = new AppContainer();
