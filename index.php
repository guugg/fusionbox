<?php

// 初始化 Blade 视图引擎
$viewFactory = init_view();

if (!$viewFactory) {
    die("无法初始化视图引擎。");
}

try {
    $archiveType = $this->getArchiveType();
    $template = match ($archiveType) {
        'post' => 'post',
        'page' => 'page',
        'category' => 'category',
        'tag' => 'tag',
        'search' => 'search',
        default => 'index',
    };

    // 渲染视图时无需手动传递 fbox
    $output = $viewFactory->make($template)->render();
    echo $output;
} catch (\Exception $e) {
    error_log("视图渲染失败: " . $e->getMessage());
    die("视图渲染失败: " . $e->getMessage());
}
