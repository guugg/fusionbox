<!-- 首页 -->


@extends('layouts.main')

@section('content')
    <div class='flex w-full flex-col gap-y-10'>
        <section class="flex flex-col gap-y-5 md:flex-row md:gap-y-0">
            <div class="text-xl font-semibold md:w-1/3">
                <h2>帖子</h2>
                {{-- {{ $fbox->commentUrl() }} --}}
                {{-- {{ $archive->user->hasLogin() }} --}}
            </div>
            <div class="flex flex-col gap-y-3 md:w-2/3">
                <!-- 显示文章列表 -->
                <div class="post-list">
                    <!-- 文章项 -->
                    @foreach ($posts as $post)
                        <div class="post-item flex flex-col gap-2 sm:flex-row sm:gap-x-4 ">
                            <time class="min-w-[120px]">
                                {{ $post->date }}
                            </time>
                            <div>
                                <a href="{{ $post->link }}" class="transition-all hover:text-muted-foreground">
                                    {{ $post->title }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- 渲染分页 -->{{-- 在某个视图文件中 --}}
                @include('partials.paging')

            </div>






        </section>





    </div>
@endsection
