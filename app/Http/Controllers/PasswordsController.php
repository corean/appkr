<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordsController extends Controller
{
    /**
     * PasswordsController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 패스워드 요청 폼
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRemind()
    {
        return view('passwords.remind');
    }

    /**
     * 패스워드 요청 처리
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRemind(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);
        $email = $request->get('email');
        $token = str_random(64);

        \DB::table('password_resets')
            ->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

        //이벤트 처리
        event(new \App\Events\PasswordRemindCreated($email, $token));

        flash('비밀번호를 바꾸는 방법을 담은 이메일을 발송했습니다. 메일주소를 확인해 주세요');
        return redirect('/');
    }


    /**
     * 비밀번호 변경요청 폼
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getReset($token)
    {
        return view('passwords.reset', compact('token'));
    }

    /**
     * 비밀번호 변경요청 처리
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed|min:4'
        ]);

        $token = $request->input('token');
        if (!\DB::table('password_resets')->whereToken($token)->first()) {
            flash('URL이 정확하지 않습니다.');
            return back()->withInput();
        }

        \DB::table('password_resets')->whereToken($token)->delete();

        $user = \DB::table('users')->whereEmail($request->input('email'));
        $user->update([
            'password' => bcrypt($request->input('password')),
        ]);

        flash('비밀번호가 변경되었습니다.');
        return redirect('/');
    }
}
