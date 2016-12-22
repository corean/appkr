@extends('layouts.app')

@section('content')
    <form action="{{ route('remind.store') }}" method="post" role="form" class="form__auth">
        {!! csrf_field() !!}
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="{{ trans('auth.form.email') }}"
                   value="{{ old('email') }}" autofocus>
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block">이메일로 비밀번호 초기화</button>
        </div>
    </form>
@endsection