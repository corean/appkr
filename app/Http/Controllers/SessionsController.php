<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destory']);
    }

    /**
     * 회원가입 폼
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sessions.create');
    }


    /**
     * 로그인 처리
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
        ]);

//        $user = auth()->attempt([
//            'email' => $request->input('email'),
//            'password' => $request->input('password'),
//        ]);

        if (!auth()->attempt(
            $request->only(['email', 'password']),
            $request->has('remember')
        )
        ) {
            return $this->respondError('이메일 또는 비밀번호가 맞지 않습니다.');
        }


        if (!auth()->user()->activated) {
            auth()->logout();
            return $this->respondError('가입 메일을 확인해 주세요.');
        }

        flash(auth()->user()->name . '님, 환영합니다.');
        return redirect()->intended('home');
    }

    /**
     * 에러 플래시와 되돌리기
     *
     * @param $message
     * @return \Illuminate\Routing\Redirector
     */
    protected function respondError($message)
    {
        flash()->error($message);
//        flash($message, 'danger');
        return redirect('/')->withInput();
    }

    /**
     * 로그아웃
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function destory()
    {
        if (auth()->check()) {
            auth()->logout();
            flash('로그아웃되었습니다.');
        } else {
            flash('로그인 상태가 아닙니다.');
        }

        return redirect('/');
    }
}


