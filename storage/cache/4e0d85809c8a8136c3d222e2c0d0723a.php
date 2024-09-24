<!-- 文章 -->




<?php $__env->startSection('content'); ?>
    <div class="mt-8 gap-x-10 lg:flex lg:items-start">
        <aside class="sticky top-20 order-2 -me-28 hidden basis-60 lg:flex lg:flex-col">
            <h2 class="font-semibold">跟随</h2>
        </aside>
        <article class="flex-grow break-words" data-pagefind-body="">
            <div id="blog-hero">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                    <p class="text-xs"> <time datetime="2023-02-22T00:00:00.000Z"> <?php echo e($post->date); ?> </time> / 2 分钟阅读 </p>
                </div>
                <h1 class="mt-2 text-3xl font-medium sm:mb-1"> <?php echo e($post->title); ?> </h1>
                <div
                    class="prose prose-base prose-zinc mt-12 prose-headings:font-medium prose-headings:before:absolute prose-headings:before:-ms-4 prose-th:before:content-none">
                    <?php echo $post->content; ?>

                </div>
            </div>

            <!-- 显示评论 -->
            <div id="comments">

                
                <?php echo $__env->make('partials.commform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php if($comments > 0): ?>
                    <h3><?php echo e($commentsNum); ?></h3>
                    <ul class="comment-list">
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('partials.comment', ['comment' => $comment], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p>暂无评论</p>
                <?php endif; ?>
            </div>


        </article>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\WWW\q.w.com\usr\themes\fusionbox\resources\views/post.blade.php ENDPATH**/ ?>