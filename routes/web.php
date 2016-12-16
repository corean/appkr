<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Route::get('auth/login', function() {
    $credentials = [
        'email' => 'john@example.com',
        'password' => 'password',
    ];
    if (! auth()->attempt($credentials)) {
        return '로그인 정보가 정확하지 않습니다.';
    }
    return redirect('protected');
});

Route::get('protected', ['middleware'=>'auth', function() {
    dump(session()->all());
    return auth()->user()->name;
}]);

Route::get('auth/logout', function () {
    auth()->logout();
    return '또 봐요~';
});

Route::any('articles', function() {
    return 'any';
});
Route::resource('articles', 'ArticlesController');
Route::put('articles/{article}', 'ArticlesController@overrideUpdate');


Auth::routes();

Route::get('/home', 'HomeController@index');

//DB::listen(function ($query){
//    dump($query);
//    printf('%s <br>', $query->sql);
//});

