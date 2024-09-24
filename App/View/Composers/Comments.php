<?php

namespace App\View\Composers;

use Carbon\Carbon;

class Comments extends BaseComposer
{
  public static function views()
  {
    return ['post'];
  }

  public function with($view)
  {
    $fbox = $view->archive;
    $user = $view->user;
    $options = $view->options;

    $comments = null;
    $fbox->comments()->to($comments);

    if ($fbox->is('single') && $fbox->allow('comment')) {

      return [
        'commentsNum' => $this->getCommentsNum($fbox),
        'comments'    => $this->getFormattedComments($comments, $fbox),
        'commentForm' => $this->getCommentFormData($fbox, $user, $options),
      ];
    }

    return [
      'commentsNum' => _t('暂无评论'),
      'comments'    => [],
      'commentForm' => '',  // 当评论不可用时返回空表单
    ];
  }

  // 封装一个捕获输出的通用函数
  protected function captureOutput(callable $callback)
  {
    ob_start();
    $callback();
    return ob_get_clean();
  }

  public function getCommentFormData($fbox, $user, $options)
  {
    return [
      'allowComment'      => $this->captureOutput(function () use ($fbox) {
        echo $fbox->allow('comment');
      }),
      'respondId'         => $this->captureOutput(function () use ($fbox) {
        echo $fbox->respondId;
      }),
      'cancelReplyLink'   => $fbox->cancelReply,
      'commentUrl'        => $fbox->commentUrl,
      'remember' => [
        'text'   => $fbox->remember('text', true) ?? '',
        'author'   => $fbox->remember('author', true) ?? '',
        'mail'   => $fbox->remember('mail', true) ?? '',
        'url'    => $fbox->remember('url', true) ?? '',
      ],
      'isLoggedIn'        => $user->hasLogin(),
      'userName'          => $user->screenName,
      'profileUrl'        => $options->profileUrl,
      'logoutUrl'    => $options->logoutUrl,
      'commentsRequireUrl' =>  $options->commentsRequireUrl,
      'commentsRequireMail' => $options->commentsRequireMail,
    ];
  }

  // 评论数量输出
  protected function getCommentsNum($fbox)
  {
    // 捕获输出
    ob_start();
    $fbox->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论'));
    return ob_get_clean();
  }

  // 获取评论列表
  protected function getFormattedComments($comments, $fbox)
  {
    $commentList = [];
    while ($comments->next()) {
      $commentList[] = $this->formatComment($comments, $fbox); // 格式化每条评论
    }
    return $commentList;
  }

  // 格式化评论
  protected function formatComment($comment, $fbox)
  {
    // 如果是数组，转换为对象
    if (is_array($comment)) {
      $comment = (object)$comment; // 转换为对象
    }

    $children = [];

    // 处理子评论
    if (!empty($comment->children)) {
      foreach ($comment->children as $child) {
        // 确保子评论也是对象
        if (is_array($child)) {
          $child = (object)$child; // 转换为对象
        }
        $children[] = $this->formatComment($child, $fbox);
      }
    }

    return (object)[
      'id'       => isset($comment->coid) ? $comment->coid : null, // 检查 coid 是否存在
      'author'   => isset($comment->author) ? $comment->author : '匿名', // 如果没有作者，返回“匿名”
      'content'  => isset($comment->text) ? $comment->text : '', // 确保使用正确的属性名
      'date'     => $this->getCommentDate($comment),
      'avatar'   => $this->getCommentAvatar($comment),
      'url'      => isset($fbox->permalink) ? $fbox->permalink : '', // 确保 permalink 存在
      'cancelReplyLink'  => $this->cancelReplyLink($comment), // 正确调用取消回复链接
      'children' => $children,
    ];
  }

  protected function cancelReplyLink($comment)
  {
    // 确保 $comment 是对象，并且它包含 cancelReply 方法
    if (is_object($comment) && method_exists($comment, 'cancelReply')) {
      ob_start(); // 开启输出缓冲
      $comment->cancelReply(); // 调用方法
      return ob_get_clean(); // 返回捕获的输出
    }

    // 如果 $comment 不是对象或者没有 cancelReply 方法，返回空字符串
    return '';
  }

  protected function getCommentDate($comment)
  {
    $timestamp = is_object($comment) ? $comment->created : ($comment['created'] ?? null);
    if (!$timestamp) return '未知日期'; // 返回中文

    $carbonDate = Carbon::createFromTimestamp($timestamp);
    Carbon::setLocale('zh'); // 设置语言为中文
    return $carbonDate->diffForHumans();
  }

  protected function getCommentAvatar($comment)
  {
    $email = is_object($comment) ? $comment->mail : ($comment['mail'] ?? null);
    $size = 40;
    $default = ''; // 默认头像

    return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . "?s={$size}&d={$default}";
  }
}
