<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticlesRequest;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = \App\Article::with('user')->latest()->paginate(3);
//        dd(view('articles.index', compact('articles'))->render());
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticlesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticlesRequest $request)
    {
        $article = \App\User::find(1)->articles()->create($request->all());

        if (! $article) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        /* 이벤트 */
        event(new \App\Events\ArticlesEvent($article));

        return redirect(route('articles.index'))->with('flash_message', '글이 저장되었습니다.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function show($id)
    {
        $article = Article::FindOrFail($id);
        return view('articles.index', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function edit($id)
    {
        return __METHOD__ . '은 다음 키를 가진 Articles 모델을 수정하기 위한 폼을 반환합니다.' . $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        return __METHOD__ . '은 사용자의 입력한 폼 데이타로 다음 기본 키를 가진 Article 모델을 수정합니다.'.$id;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return __METHOD__ . '은 다음 키를 가진 Articles 모델을 삭제합니다.' . $id;
    }

    public function overrideUpdate($id)
    {
        return __METHOD__ . '은 사용자의 입력한 폼 데이타로 다음 기본 키를 가진 오버라이드(override)된 Article 모델을 수정합니다.'.$id;
    }

}
