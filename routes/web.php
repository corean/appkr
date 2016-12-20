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

Route::get('markdown', function() {
    $text =<<<EOT
# 마크다운 예제1

이 문서는 [마크다운][1]으로 썼습니다. 화면에는 HTML로 변환되어 출력됩니다.

## 순서 없는 목록

- 첫번째 항목
- 두번째 항목[^1]

[1]: http://daringfireball.net/projects/markdown
[^1]: 두번째 항목_ http://google.com

EOT;
    return app(ParsedownExtra::class)->text($text);

});

Route::get('docs/{file?}', 'DocsController@show');
Route::get('docs/images/{image}', 'DocsController@image')->where('image', '[\pL-\pN\._-]+-img-[0-9]{2}.png');