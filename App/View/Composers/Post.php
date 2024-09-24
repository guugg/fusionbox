<?php

namespace App\View\Composers;

class Post extends BaseComposer
{
  public static function views()
  {
    return [
      '*', // 可以根据需要指定视图
    ];
  }

  public function with($view)
  {
    // 获取传递给视图的 fbox 对象
    $fbox = $view->archive;
    $currentPage = $fbox->request->get('page', 1);

    // 判断是文章列表还是单篇文章
    if ($fbox->is('single')) {
      return [
        'post' => $this->getCachedData("single_post_{$fbox->id}", 3600, function () use ($fbox) {
          return $this->getSinglePost($fbox); // 获取单篇文章
        }),
      ];
    } else {
      // 为每个分页生成不同的缓存键
      return [
        'posts' => $this->getCachedData("posts_list_page_{$currentPage}", 3600, function () use ($fbox) {
          return $this->getPosts($fbox); // 获取文章列表
        }),
      ];
    }
  }

  /**
   * 获取文章列表
   *
   * @param object $fbox
   * @return array
   */
  protected function getPosts($fbox)
  {
    $posts = [];

    while ($fbox->next()) {
      $posts[] = (object)[
        'title'       => $this->getTitle($fbox),      // 标题
        'link'        => $this->getPermalink($fbox),  // 链接
        'excerpt'     => $this->getExcerpt($fbox),    // 摘要
        'date'        => $this->getDate($fbox),       // 发布日期
        'author'      => $this->getAuthor($fbox),     // 作者
        'categories'  => $this->getCategories($fbox), // 分类
        'tags'        => $this->getTags($fbox),       // 标签
        'commentsNum' => $this->getCommentsNum($fbox), // 评论数量
      ];
    }

    return $posts;
  }

  /**
   * 获取单篇文章内容
   *
   * @param object $fbox
   * @return object
   */
  protected function getSinglePost($fbox)
  {
    return (object)[
      'title'        => $this->getTitle($fbox),       // 标题
      'link'         => $this->getPermalink($fbox),   // 链接
      'content'      => $this->getContent($fbox),     // 内容
      'date'         => $this->getDate($fbox),        // 发布日期
      'author'       => $this->getAuthor($fbox),      // 作者
      'categories'   => $this->getCategories($fbox),  // 分类
      'tags'         => $this->getTags($fbox),        // 标签
    ];
  }

  /**
   * 获取文章标题
   *
   * @param object $fbox
   * @return string
   */
  protected function getTitle($fbox)
  {
    return $fbox->title;
  }

  /**
   * 获取文章内容
   *
   * @param object $fbox
   * @return string
   */
  protected function getContent($fbox)
  {
    return $fbox->content;
  }

  /**
   * 获取文章摘要
   *
   * @param object $fbox
   * @return string
   */
  protected function getExcerpt($fbox, $length = 100)
  {
    // 使用自定义摘要字段
    if (isset($fbox->fields->excerpt) && !empty($fbox->fields->excerpt)) {
      return $fbox->fields->excerpt;
    }

    // 否则截取文章内容的摘要
    $content = strip_tags($fbox->content);
    $excerpt = mb_substr($content, 0, $length, 'UTF-8');

    // 如果文章内容超过摘要长度，添加省略号
    if (mb_strlen($content) > $length) {
      $excerpt .= '...';
    }

    return $excerpt;
  }

  /**
   * 获取文章永久链接
   *
   * @param object $fbox
   * @return string
   */
  protected function getPermalink($fbox)
  {
    return $fbox->permalink;
  }

  /**
   * 获取文章作者
   *
   * @param object $fbox
   * @return string
   */
  protected function getAuthor($fbox)
  {
    return $fbox->author->screenName ?? 'Unknown';
  }

  /**
   * 获取文章发布日期
   *
   * @param object $fbox
   * @return string
   */
  protected function getDate($fbox)
  {
    return date('Y-m-d', $fbox->created);
  }

  /**
   * 获取文章分类
   *
   * @param object $fbox
   * @return array
   */
  protected function getCategories($fbox)
  {
    return array_map(function ($category) {
      return [
        'name' => $category['name'],
        'link' => $category['permalink']
      ];
    }, $fbox->categories ?? []);
  }

  /**
   * 获取文章标签
   *
   * @param object $fbox
   * @return array
   */
  protected function getTags($fbox)
  {
    return array_map(function ($tag) {
      return [
        'name' => $tag['name'],
        'link' => $tag['permalink']
      ];
    }, $fbox->tags ?? []);
  }

  /**
   * 获取评论数量
   *
   * @param object $fbox
   * @return int
   */
  protected function getCommentsNum($fbox)
  {
    return $fbox->commentsNum;
  }
}
