{{-- <pre>{{ var_dump($commentForm) }}</pre> --}}

{{-- 判断是否允许评论 --}}
@if ($commentForm['allowComment'])
    <form class=" " action="{{ $commentForm['commentUrl'] }}" id="comment-form" method="post" role="form">

        <h2 class="text-xl mb-4 tracking-wider font-lighter ">发表评论</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3" method="post" action="{{ $commentForm['commentUrl'] }}"
            id="comment-form" role="form">
            <div class="mb-4 col-span-1 md:col-span-3">
                <textarea id="comment" name="comment"
                    class="w-full px-3 py-2 bg-transparent rounded-sm border focus:outline-none border-solid focus:border-dashed resize-none"
                    placeholder="评论内容..." rows="4" cols="400" name="text" id="textarea" required>{{ $commentForm['remember']['text'] }}
                </textarea>
            </div>

            @if ($commentForm['isLoggedIn'])
                <p>
                    登录身份：<a href="{{ $commentForm['profileUrl'] }}">{{ $commentForm['userName'] }}</a>
                    <span class="mx-2 text-muted">&middot;</span>
                    <a href="{{ $commentForm['logoutUrl'] }}">退出</a>
                </p>
            @else
                <div class="mb-4">
                    <input type="text" id="author" name="author"
                        value="{{ $commentForm['remember']['author'] ?? '' }}"
                        class="w-full px-3 py-2 bg-transparent rounded-sm border focus:outline-none border-solid focus:border-dashed"
                        placeholder="名字*" required />
                </div>
                <div class="mb-4">
                    <input type="mail" id="mail" name="mail"
                        value="{{ $commentForm['remember']['mail'] ?? '' }}"
                        @if ($commentForm['commentsRequireMail']) class="w-full px-3 py-2 bg-transparent rounded-sm border focus:outline-none border-solid focus:border-dashed"
                        placeholder="邮箱*" required @endif />
                </div>
                <div class="mb-4">
                    <input type="url" id="url" name="url"
                        placeholder="http://网站 @if (!$commentForm['commentsRequireUrl']) （选填） @endif"
                        value="{{ $commentForm['remember']['url'] ?? '' }}"
                        class="w-full px-3 py-2 bg-transparent rounded-sm border  focus:outline-none border-solid focus:border-dashed"
                        placeholder="Website" @if ($commentForm['commentsRequireUrl']) required @endif />
                </div>
        </div>
@endif
<div class="flex justify-end">
    <button type="submit" class="py-4 px-6 focus:outline-none focus:ring-2 focus:ring-offset-2 ">
        提交评论 →
    </button>
</div>
</form>
@else
<p>评论功能已关闭。</p>
@endif


