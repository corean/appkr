@extends('layouts.master')

@section('style')
    <style>
        body { background: green; color: white; }
    </style>
@endsection

@section('content')
    <p>자식 뷰 'content' 섹션</p>
    @include('partials.footer')
@endsection

@section('script')
    <script>
        alert('I am Child-View.');
    </script>
@endsection