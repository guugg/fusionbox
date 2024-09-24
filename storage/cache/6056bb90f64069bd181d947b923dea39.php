

<!-- component -->

<!-- 单个评论 -->
<ol id="comment-<?php echo e($comment->id ?? ''); ?>" class="p-4 rounded-lg space-y-4">
    <li class="comment-body">
        <div>
            <!-- 评论用户信息 -->
            <div class="flex items-start space-x-4">
                <img class="avatar" src="<?php echo e($comment->avatar ?? ''); ?>" alt="<?php echo e($comment->author ?? '匿名'); ?>" width="40"
                    height="40">
                <div>
                    <h4 class="font-semibold"><a href="<?php echo e($comment->url ?? '#'); ?>"><?php echo e($comment->author ?? '匿名'); ?></a>
                    </h4>
                    <p class="text-sm "><?php echo e($comment->date ?? ''); ?></p>
                </div>
            </div>

            <!-- 评论内容 -->
            <p class="">
                <?php echo $comment->content ?? ''; ?>

            </p>

            <!-- 回复按钮 -->
            <a href="<?php echo e($comment->url ?? '#'); ?>">
                <span class="comment-reply">回复</span>
            </a>
            <div class="cancel-comment-reply">
                <?php echo $comment->cancelReplyLink ?? ''; ?>

            </div>
        </div>
        <!-- 嵌套回复 -->

        
        <?php if(!empty($comment->children)): ?>
            
            <?php $__currentLoopData = $comment->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php echo $__env->make('partials.comment', ['comment' => $child], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>


    </li>
</ol>
<?php /**PATH D:\www\WWW\q.w.com\usr\themes\fusionbox\resources\views/partials/comment.blade.php ENDPATH**/ ?>