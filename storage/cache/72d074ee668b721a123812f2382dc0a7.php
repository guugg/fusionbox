


<?php if($commentForm['allowComment']): ?>
    <form class=" " action="<?php echo e($commentForm['commentUrl']); ?>" id="comment-form" method="post" role="form">

        <h2 class="text-xl mb-4 tracking-wider font-lighter ">发表评论</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3" method="post" action="<?php echo e($commentForm['commentUrl']); ?>"
            id="comment-form" role="form">
            <div class="mb-4 col-span-1 md:col-span-3">
                <textarea id="comment" name="comment"
                    class="w-full px-3 py-2 bg-transparent rounded-sm border focus:outline-none border-solid focus:border-dashed resize-none"
                    placeholder="评论内容..." rows="4" cols="400" name="text" id="textarea" required><?php echo e($commentForm['remember']['text']); ?>

                </textarea>
            </div>

            <?php if($commentForm['isLoggedIn']): ?>
                <p>
                    登录身份：<a href="<?php echo e($commentForm['profileUrl']); ?>"><?php echo e($commentForm['userName']); ?></a>
                    <span class="mx-2 text-muted">&middot;</span>
                    <a href="<?php echo e($commentForm['logoutUrl']); ?>">退出</a>
                </p>
            <?php else: ?>
                <div class="mb-4">
                    <input type="text" id="author" name="author"
                        value="<?php echo e($commentForm['remember']['author'] ?? ''); ?>"
                        class="w-full px-3 py-2 bg-transparent rounded-sm border focus:outline-none border-solid focus:border-dashed"
                        placeholder="名字*" required />
                </div>
                <div class="mb-4">
                    <input type="mail" id="mail" name="mail"
                        value="<?php echo e($commentForm['remember']['mail'] ?? ''); ?>"
                        <?php if($commentForm['commentsRequireMail']): ?> class="w-full px-3 py-2 bg-transparent rounded-sm border focus:outline-none border-solid focus:border-dashed"
                        placeholder="邮箱*" required <?php endif; ?> />
                </div>
                <div class="mb-4">
                    <input type="url" id="url" name="url"
                        placeholder="http://网站 <?php if(!$commentForm['commentsRequireUrl']): ?> （选填） <?php endif; ?>"
                        value="<?php echo e($commentForm['remember']['url'] ?? ''); ?>"
                        class="w-full px-3 py-2 bg-transparent rounded-sm border  focus:outline-none border-solid focus:border-dashed"
                        placeholder="Website" <?php if($commentForm['commentsRequireUrl']): ?> required <?php endif; ?> />
                </div>
        </div>
<?php endif; ?>
<div class="flex justify-end">
    <button type="submit" class="py-4 px-6 focus:outline-none focus:ring-2 focus:ring-offset-2 ">
        提交评论 →
    </button>
</div>
</form>
<?php else: ?>
<p>评论功能已关闭。</p>
<?php endif; ?>


<?php /**PATH D:\www\WWW\q.w.com\usr\themes\fusionbox\resources\views/partials/commform.blade.php ENDPATH**/ ?>