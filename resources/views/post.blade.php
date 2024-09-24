<!-- 文章 -->


@extends('layouts.main')

@section('content')
    <div class="mt-8 gap-x-10 lg:flex lg:items-start">
        <aside class="sticky top-20 order-2 -me-28 hidden basis-60 lg:flex lg:flex-col">
            <h2 class="font-semibold">跟随</h2>
        </aside>
        <article class="flex-grow break-words" data-pagefind-body="">
            <div id="blog-hero">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                    <p class="text-xs"> <time datetime="2023-02-22T00:00:00.000Z"> {{ $post->date }} </time> / 2 分钟阅读 </p>
                </div>
                <h1 class="mt-2 text-3xl font-medium sm:mb-1"> {{ $post->title }} </h1>
                <div
                    class="prose prose-base prose-zinc mt-12 prose-headings:font-medium prose-headings:before:absolute prose-headings:before:-ms-4 prose-th:before:content-none">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- 显示评论 -->
            <div id="comments">

                {{-- 显示评论输入表单 --}}
                @include('partials.commform')

                @if ($comments > 0)
                    <h3>{{ $commentsNum }}</h3>
                    <ul class="comment-list">
                        @foreach ($comments as $comment)
                            @include('partials.comment', ['comment' => $comment])
                        @endforeach
                    </ul>
                @else
                    <p>暂无评论</p>
                @endif
            </div>


        </article>


    </div>
@endsection
