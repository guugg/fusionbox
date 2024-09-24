<?php

// 初始化 Blade 视图引擎和缓存服务
$viewFactory = init_view();
$cache = init_cache(); // 假设你已经有 init_cache() 函数来初始化缓存服务

// 确保视图引擎已经初始化
if (!$viewFactory || !$cache) {
  die("无法初始化视图引擎或缓存服务。");
}

// 定义缓存时长（秒）
$cacheDuration = 600; // 缓存10分钟

// 定义页面的缓存键（根据页面类型动态生成）
$pageType = $this->is('post') ? 'post' : ($this->is('page') ? 'page' : ($this->is('category') ? 'category' : ($this->is('tag') ? 'tag' : ($this->is('search') ? 'search' : 'index'))));

$cacheKey = "view_cache_{$pageType}_" . $this->id; // 假设每个页面都有唯一ID

// 检查缓存是否存在
if ($cache->has($cacheKey)) {
  // 缓存命中，输出调试信息
  var_dump("查看缓存命中: $cacheKey");
  // 如果缓存存在，直接输出缓存内容
  echo $cache->get($cacheKey);
} else {
  // 如果缓存不存在，渲染并缓存视图
  try {
    // 缓存未命中，输出调试信息
    var_dump("查看缓存未命中: $cacheKey");
    // 根据不同页面类型渲染对应模板
    $output = '';
    if ($this->is('post')) {
      $output = $viewFactory->make('post')->with('fbox', $this)->render();
    } elseif ($this->is('page')) {
      $output = $viewFactory->make('page')->with('fbox', $this)->render();
    } elseif ($this->is('category')) {
      $output = $viewFactory->make('category')->with('fbox', $this)->render();
    } elseif ($this->is('tag')) {
      $output = $viewFactory->make('tag')->with('fbox', $this)->render();
    } elseif ($this->is('search')) {
      $output = $viewFactory->make('search')->with('fbox', $this)->render();
    } else {
      $output = $viewFactory->make('index')->with('fbox', $this)->render();
    }

    // 将渲染结果缓存起来
    $cache->put($cacheKey, $output, $cacheDuration);

    // 输出渲染结果
    echo $output;
  } catch (\Exception $e) {
    error_log("视图渲染失败: " . $e->getMessage());
    die("视图渲染失败: " . $e->getMessage());
  }
}
