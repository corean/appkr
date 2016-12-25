<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

        if ($socialUser = \App\User::socialUser($request->get('email'))->first()) {
            return $this->updateSocialAccount($request, $socialUser);
        }

        return $this->createNativeAccount($request);
    }

    public function updateSocialAccount(Request $request, \App\User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:4|confirmed',
        ]);
        $user->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ]);
        auth()->login($user);
        return $this->respondCreated($user->name . '님, 환영합니다.');
    }

    protected function respondCreated($message)
    {
        flash($message);
        return redirect('/');
    }

    public function createNativeAccount($request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:4|confirmed',
        ]);
        $confirmCode = str_random(60);
        $user = \App\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'confirm_code' => $confirmCode,
        ]);

        //이벤트처리
        event(new \App\Events\userCreated($user));

        return $this->respondCreated('가입하신 ' . $request->input('email') . '으로 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해 주세요.');
    }

    public function confirm($code)
    {
        $user = \App\User::where('Confirm_code', $code)->first();
        if (!$user) {
            flash('URL이 정확하지 않습니다.');
            return redirect('/');
        }
        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);
        return $this->respondCreated(auth()->user()->name . '님, 환영합니다. 가입이 확인되었습니다.');
    }
}
