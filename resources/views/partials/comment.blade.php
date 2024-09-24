{{-- resources/views/partials/comment.blade.php --}}

<!-- component -->

<!-- 单个评论 -->
<ol id="comment-{{ $comment->id ?? '' }}" class="p-4 rounded-lg space-y-4">
    <li class="comment-body">
        <div>
            <!-- 评论用户信息 -->
            <div class="flex items-start space-x-4">
                <img class="avatar" src="{{ $comment->avatar ?? '' }}" alt="{{ $comment->author ?? '匿名' }}" width="40"
                    height="40">
                <div>
                    <h4 class="font-semibold"><a href="{{ $comment->url ?? '#' }}">{{ $comment->author ?? '匿名' }}</a>
                    </h4>
                    <p class="text-sm ">{{ $comment->date ?? '' }}</p>
                </div>
            </div>

            <!-- 评论内容 -->
            <p class="">
                {!! $comment->content ?? '' !!}
            </p>

            <!-- 回复按钮 -->
            <a href="{{ $comment->url ?? '#' }}">
                <span class="comment-reply">回复</span>
            </a>
            <div class="cancel-comment-reply">
                {!! $comment->cancelReplyLink ?? '' !!}
            </div>
        </div>
        <!-- 嵌套回复 -->

        {{-- 检查评论是否有子级（嵌套评论） --}}
        @if (!empty($comment->children))
            {{-- 循环遍历子评论并递归地包含相同的模板 --}}
            @foreach ($comment->children as $child)
                {{-- 递归地包含相同的模板 --}}
                @include('partials.comment', ['comment' => $child])
            @endforeach
        @endif


    </li>
</ol>
