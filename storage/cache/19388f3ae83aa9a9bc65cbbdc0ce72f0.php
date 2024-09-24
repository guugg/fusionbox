<!-- 导航 -->


<header class="mb-12 flex w-full flex-wrap pb-3 text-sm sm:flex-nowrap sm:justify-start">
    <nav class="relative mx-auto flex w-full items-center justify-between sm:flex sm:items-center">
        <a class='flex-none text-xl font-semibold' href='/' aria-label='Brand'><?php echo e($siteName ?? '入门主题'); ?></a>
        <div class="flex flex-row items-center justify-center gap-x-5 sm:gap-x-7">
            <a href="/" data-turbo-frame="main">首页</a>
            <a href="/start-page.html" data-turbo-frame="main">关于我们</a>
            <a href="/archives/41.html" data-turbo-frame="main">文章</a>

            <!-- 新的自定义主题切换下拉 -->
            <!-- 触发按钮 -->
            <button id="theme-button" class="flex items-center text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M4.93 4.93a10 10 0 0114.14 0m0 14.14a10 10 0 01-14.14 0m7.07-7.07v.01" />
                </svg>
            </button>

        </div>
    </nav>
</header>



<!-- 悬浮的下拉菜单，在 body 中 -->
<div id="theme-menu" class="hidden w-40  fixed z-50">
    <button class="block w-full px-4 py-2 text-left text-sm " data-theme="light">光明</button>
    <button class="block w-full px-4 py-2 text-left text-sm" data-theme="dark">暗黑</button>
    <button class="block w-full px-4 py-2 text-left text-sm" data-theme="pinks">粉色</button>
</div>
<?php /**PATH D:\www\WWW\q.w.com\usr\themes\fusionbox\resources\views/sections/header.blade.php ENDPATH**/ ?>