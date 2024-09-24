<!-- 首页 -->




<?php $__env->startSection('content'); ?>
    <div class='flex w-full flex-col gap-y-10'>
        <section class="flex flex-col gap-y-5 md:flex-row md:gap-y-0">
            <div class="text-xl font-semibold md:w-1/3">
                <h2>帖子</h2>
                
                
            </div>
            <div class="flex flex-col gap-y-3 md:w-2/3">
                <!-- 显示文章列表 -->
                <div class="post-list">
                    <!-- 文章项 -->
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="post-item flex flex-col gap-2 sm:flex-row sm:gap-x-4 ">
                            <time class="min-w-[120px]">
                                <?php echo e($post->date); ?>

                            </time>
                            <div>
                                <a href="<?php echo e($post->link); ?>" class="transition-all hover:text-muted-foreground">
                                    <?php echo e($post->title); ?>

                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- 渲染分页 -->
                <?php echo $__env->make('partials.paging', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>






        </section>





    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\WWW\q.w.com\usr\themes\fusionbox\resources\views/index.blade.php ENDPATH**/ ?>