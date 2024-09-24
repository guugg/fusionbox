<!DOCTYPE html>
<html lang="zh-CN" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title><?php echo e($siteName ?? 'My Site'); ?></title>
    <!-- Laravel Blade 样式和脚本 -->
    <?php if(defined('APP_ENV') && APP_ENV === 'development'): ?>
        <!-- 开发模式：使用 Vite 开发服务器 -->
        <script type="module" src="http://localhost:3300/src/turbo.ts"></script>
        <!-- <script type="module" src="http://localhost:3300/src/main.ts"></script> -->
    <?php else: ?>
        <!-- 生产模式：使用构建后的资源 -->
        <link rel="stylesheet" href="<?php echo \Utils\Helper::options()->themeUrl('public/dist/app.css'); ?>">
        <script type="module" src="<?php echo \Utils\Helper::options()->themeUrl('public/dist/app.js'); ?>"></script>
    <?php endif; ?>


</head>

<body>



    <div class="flex justify-center bg-background">
        <main class="flex min-h-screen w-screen max-w-[60rem] flex-col  px-6 pb-10 pt-7 font-satoshi  sm:px-10 lg:px-10"
            id="app" data-turbo-frame="main">

            <?php echo $__env->make('sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </main>
    </div>


</body>

</html>
<?php /**PATH D:\www\WWW\q.w.com\usr\themes\fusionbox\resources\views/layouts/main.blade.php ENDPATH**/ ?>