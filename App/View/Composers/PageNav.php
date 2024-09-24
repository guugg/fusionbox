<?php

namespace App\View\Composers;

use Typecho\Widget; // 引入 Typecho 组件

class PageNav extends BaseComposer
{
  public static function views()
  {
    return [
      '*', // 可根据需求添加更多视图
    ];
  }

  public function with($view)
  {
    $fbox = $view->archive;
    return [
      'pagination' => $this->generatePagination($fbox),  // 返回分页HTML
      'loadMorePagination' => $this->loadMorePagination()  // 加载更多分页
    ];
  }

  /**
   * 生成分页导航
   * 根据当前页面类型选择不同的分页逻辑
   *
   * @return string
   */
  protected function generatePagination($fbox)
  {
    // 获取当前的 fbox 实例

    // 判断页面是否是单篇文章（用于评论分页）还是文章列表
    if ($fbox->is('single')) {
      // 如果是单篇文章页面，则使用评论分页
      return $this->commentPagination();
    } else {
      // 如果是文章列表页面，则使用文章分页
      return $this->articlePagination($fbox);
    }
  }

  /**
   * 文章列表的分页
   *
   * @param Widget_Archive $fbox
   * @return string
   */
  protected function articlePagination(\Widget\Archive $fbox)
  {
    // 缓存分页导航，缓存时间1小时
    $currentPage = $fbox->request->get('page', 1);
    $cacheKey = 'pagination_' . $currentPage;

    return $this->getCachedData($cacheKey, 3600, function () use ($fbox) {
      ob_start();
      $fbox->pageNav('上一页', '下一页', 1, '...');
      return ob_get_clean();
    });
  }

  /**
   * 评论的分页
   *
   * @return string
   */
  protected function commentPagination()
  {
    // 获取当前文章的评论Widget
    $comments = Widget::widget('\Widget\Comments\Archive');

    // 检查是否有评论分页
    if ($comments->havePages()) {
      $pageNavConfig = array(
        'wrapTag' => 'ol',
        'wrapClass' => 'page-navigator',
        'itemTag' => 'li',
        'textTag' => 'span',
        'currentClass' => 'current',
        'prevClass' => 'prev',
        'nextClass' => 'next',
      );

      ob_start();
      $comments->pageNav('«', '»', 1, '...', $pageNavConfig);
      return ob_get_clean();
    }

    // 如果没有分页，则返回空
    return '';
  }

  /**
   * 加载更多分页
   * 返回下一页的链接，点击加载更多内容
   *
   * @return string
   */
  protected function loadMorePagination()
  {
    $fbox = Widget::widget('\Widget\Archive');
    if ($fbox->is('single')) {
      return '';
    } else {
      $currentPage = $fbox->request->get('page', 1);
      $nextPage = $currentPage + 1;
      $pageSize = $fbox->parameter->pageSize;
      $totalItems = $fbox->getTotal();
      $totalPages = ceil($totalItems / $pageSize);

      if ($nextPage <= $totalPages) {
        // 使用 AJAX 动态加载内容，而不是直接返回所有分页 HTML
        $loadMoreUrl = '/' . '?page=' . $nextPage;

        return sprintf(
          '<a href="%s" class="load-more-btn" data-next-page="%d">加载更多</a>',
          $loadMoreUrl,
          $nextPage
        );
      }

      return '';
    }
  }
}
