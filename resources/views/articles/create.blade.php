@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>포럼글쓰기</h1>
        <hr>
        <form action="{{ route('articles.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="">제목</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                {!! $errors->first('title', '<span class="form-error">:message</span') !!}
            </div>
            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                <label for="">본문</label>
                <textarea name="content" id="content"  class="form-control" rows="10">{{ old('content') }}</textarea>
                {!! $errors->first('content', '<span class="form-error">:message</span') !!}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">저장하기</button>
            </div>
        </form>
    </div>
@endsection