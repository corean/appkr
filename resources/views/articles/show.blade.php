@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h4>포럼
            <small>/ {{ $article->title }}</small>
        </h4>
    </div>

    <article data-id="{{ $article->id }}">
        @include('articles.partial.article', compact('article'))
        <p>{!! markdown($article->content) !!}</p>
    </article>

    <div class="text-right action__article">
        {{-- 글 삭제 --}}
        @can('update', $article)
            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> 글 수정</a>
        @endcan
        {{-- 글 수정 --}}
        @can('delete', $article)
            <button class="btn btn-danger btn__delete"><i class="fa fa-trash-o"></i> 글 삭제</button>
        @endcan
        <a href="{{ route('articles.index') }}" class="btn btn-default">
            <i class="fa fa-list"></i> 글 목록
        </a>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.btn__delete').on('click', function (e) {
            var articleId = $('article').data('id');
            if (confirm('글을 삭제합니다.')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/articles/' + articleId
                }).then(function () {
                    window.location.href = '/articles';
                });
            }
        });
    </script>
@endsection