<?php

/**
 * 主题过滤器。
 */

namespace App;



// 示例：自定义文章标题格式
\Typecho\Plugin::factory('Widget_Archive')->title = function ($title) {
  return '自定义前缀: ' . $title;
};



// 示例：自定义文章标题格式
\Typecho\Plugin::factory('Widget_Archive')->pageNav = function (
  $currentPage,  //当前页码
  $total,        // 总文章数
  $pageSize,     // 每页显示的文章数量
  $prev,         // 上一页按钮的文本
  $next,         // 下一页按钮的文本
  $splitPage,    // 是否需要分页
  $splitWord,    // 分页符
  $template,     // 分页样式模板
  $query         // 分页链接模板
) {
  // 计算总页数
  $totalPages = ceil($total / $pageSize);

  if ($totalPages < 2) {
    return; // 没有必要分页
  }

  $defaultTemplate = [
    'on' => 'div',              // 上一页 包裹
    'onClass' => '-mt-px flex w-0 flex-1',  // 上一页 包裹样式
    'in' => 'div',              // 数字分页 包裹
    'inClass' => 'hidden md:-mt-px md:flex',  //  数字分页 包裹样式
    'under' => 'div',           // 下一页页 包裹
    'underClass' => '-mt-px flex w-0 flex-1 justify-end', // 下一页 包裹样式

    'linkClass' => 'inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium', // a 标签的统一 class
    'activeClass' => 'active',        // 当前页的额外 class
    'textTag' => 'span',           // 分页文本符号的 包裹
    'textTagClass' => 'inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium',           // 分页文本符号的 class
  ];

  $template = array_merge($defaultTemplate, $template);
  extract($template);

  // 页码范围
  $from = max(1, $currentPage - $splitPage);
  $to = min($totalPages, $currentPage + $splitPage);

  // 输出上一页
  echo '<' . $on . ' class="-mt-px flex w-0 flex-1">';
  if ($currentPage > 1) {
    $prevLink = str_replace('{page}', $currentPage - 1, $query);
    echo '<a href="' . $prevLink . '" class="' . $linkClass . '">' . $prev . '</a>';
  } else {
    echo '<a href="#" class="' . $linkClass . '">' . $prev . '</a>';
  }
  echo '</' . $on . '>';

  echo '<' . $in . ' class="' . $template['inClass'] . '">';
  // 输出第一页
  if ($from > 1) {
    echo '<a href="' . str_replace('{page}', 1, $query) . '" class="' . $linkClass . '">1</a>';
    if ($from > 2) {
      echo '<' . $textTag . ' class="' . $textTagClass . '">' . $splitWord . '</' . $textTag . '>';
    }
  }

  // 输出中间页码
  for ($i = $from; $i <= $to; $i++) {
    if ($i == $currentPage) {
      // 当前页增加 activeClass
      echo '<a href="' . str_replace('{page}', $i, $query) . '" class="' . $linkClass . ' ' . $activeClass . '">' . $i . '</a>';
    } else {
      echo '<a href="' . str_replace('{page}', $i, $query) . '" class="' . $linkClass . '">' . $i . '</a>';
    }
  }

  // 输出最后一页
  if ($to < $totalPages) {
    if ($to < $totalPages - 1) {
      echo '<' . $textTag . ' class="' . $textTagClass . '">' . $splitWord . '</' . $textTag . '>';
    }
    echo '<a href="' . str_replace('{page}', $totalPages, $query) . '" class="' . $linkClass . '">' . $totalPages . '</a>';
  }
  echo '</' . $in . '>';

  // 输出下一页
  echo '<' . $under . ' class="' . $underClass . '">';
  if ($currentPage < $totalPages) {
    $nextLink = str_replace('{page}', $currentPage + 1, $query);
    echo '<a href="' . $nextLink . '" class="' . $linkClass . '">' . $next . '</a>';
  } else {
    echo '<a href="###" class="' . $linkClass . '">' . $next . '</a>';
  }
  echo '</' . $under . '>';
};
