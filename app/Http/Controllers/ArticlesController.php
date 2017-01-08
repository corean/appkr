<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use App\Http\Requests\ArticlesRequest;
use App\Events\ArticlesEvent;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('user')->latest()->paginate(5);
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
        $article = new Article;
        return view('articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticlesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticlesRequest $request)
    {
        //$article = User::find(auth()->user())->articles()->create($request->all());
        $article = $request->user()->articles()->create($request->all());

        if (! $article) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        /* 이벤트 */
        event(new ArticlesEvent($article));

        return redirect(route('articles.index'))->with('flash_message', '글이 저장되었습니다.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article $article
     * @return string
     */
    public function show(Article $article)
    {
//        $article = Article::FindOrFail($id);
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article $article
     * @return string
     */
    public function edit(\App\Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticlesRequest $request
     * @param  \App\Article $article

     * @return string
     */
    public function update(ArticlesRequest $request, Article $article)
    {
//        return __METHOD__ . '은 사용자의 입력한 폼 데이타로 다음 기본 키를 가진 Article 모델을 수정합니다.'.$id;
//        dd($request, $article);
        $article->update($request->all());

        if (!$article) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        /* 이벤트 */
//        event(new \App\Events\ArticlesEvent($article));
        flash()->success('글이 수정되었습니다.');
        return redirect(route('articles.show', $article->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        return response()->json([], 204);
    }

    public function overrideUpdate($id)
    {
        return __METHOD__ . '은 사용자의 입력한 폼 데이타로 다음 기본 키를 가진 오버라이드(override)된 Article 모델을 수정합니다.'.$id;
    }

}
