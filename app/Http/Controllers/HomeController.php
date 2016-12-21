<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        flash('환영합니다');
        flash()->success('성공');
        flash()->warning('주의');
        flash('경고', 'danger');
        flash()->overlay('모달 메세지', '제목');
        return view('home');
    }
}
