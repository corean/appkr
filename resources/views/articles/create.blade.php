@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>포럼글쓰기</h1>
        <hr>
        <form action="{{ route('articles.store') }}" method="post">
            {!! csrf_field() !!}
            @include('articles.partial.form')
        </form>
    </div>
@endsection