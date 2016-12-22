@extends('layouts.app')

@section('content')
    <form action="{{ route('sessions.create') }}" method="post" class="form__auth">
        {!! csrf_field() !!}
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="text" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}">
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" name="password" class="form-control" placeholder="비밀번호">
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label for="remember">
                    <input type="checkbox" name="remember" value="{{ old('remember', 1) }}" checked>
                    로그인 기억하기
                    <span class="text-danger">(공용pc에서는 사용하지 마세요!)</span>

                </label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">로그인</button>
        </div>
        <div>
            <p class="text-center">회원이 아니시라면?
                <a href="{{ route('users.create') }}">가입하세요</a>
            </p>
            <p class="text-center">
                <a href="{{ route('remind.create') }}">비밀번호를 잊으셨나요?</a>
            </p>
        </div>
    </form>

@endsection