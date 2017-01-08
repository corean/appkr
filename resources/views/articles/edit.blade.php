@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h4>포럼
            <small> / 글 수정 / {{ $article->title }}</small>
        </h4>
    </div>

    <form action="{{ route('articles.update', $article->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        @include('articles.partial.form')

    </form>

@endsection