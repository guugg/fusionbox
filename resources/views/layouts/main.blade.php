<!DOCTYPE html>
<html lang="zh-CN" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>{{ $siteName ?? 'My Site' }}</title>
    <!-- Laravel Blade 样式和脚本 -->
    @if (defined('APP_ENV') && APP_ENV === 'development')
        <!-- 开发模式：使用 Vite 开发服务器 -->
        <script type="module" src="http://localhost:3300/src/turbo.ts"></script>
        <!-- <script type="module" src="http://localhost:3300/src/main.ts"></script> -->
    @else
        <!-- 生产模式：使用构建后的资源 -->
        <link rel="stylesheet" href="<?php echo \Utils\Helper::options()->themeUrl('public/dist/app.css'); ?>">
        <script type="module" src="<?php echo \Utils\Helper::options()->themeUrl('public/dist/app.js'); ?>"></script>
    @endif


</head>

<body>



    <div class="flex justify-center bg-background">
        <main class="flex min-h-screen w-screen max-w-[60rem] flex-col  px-6 pb-10 pt-7 font-satoshi  sm:px-10 lg:px-10"
            id="app" data-turbo-frame="main">

            @include('sections.header')
            @yield('content')
            @include('sections.footer')
        </main>
    </div>


</body>

</html>
