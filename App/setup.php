<?php


/**
 * Theme setup.
 */

namespace App;
// 主题初始化逻辑
function themeInit()
{
  // 注册主题菜单
  // 例如你可以在这里初始化导航、侧边栏等
}

// 加载前端样式和脚本
function enqueueThemeAssets()
{
  // 加载样式
  echo '<link rel="stylesheet" href="' . \Utils\Helper::options()->themeUrl('resources/styles/app.css') . '">';

  // 加载 JS （可以结合 Vue 或其他前端框架）
  echo '<script src="' . \Utils\Helper::options()->themeUrl('src/app.js') . '"></script>';
}

themeInit();


