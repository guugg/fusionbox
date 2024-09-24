{{-- resources/views/partials/paging.blade.php --}}

@if ($pagination)
    <nav class="flex items-center justify-between border-t px-4 sm:px-0 ">
        {!! $pagination !!}
    </nav>
@endif

@if ($loadMorePagination)
    <div class="flex justify-center">
        {!! $loadMorePagination !!}
    </div>
@endif
