<?php

namespace App\Listeners;

use \App\Article;
use \App\Events\ArticlesEvent;
//use App\Events\article.created;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class ArticlesEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\ArticlesEvent $event
     * @return void
     */
    public function handle(ArticlesEvent $event)
    {
        if ($event->action == 'created') {
            \Log::info(sprintf('새로운 포럼 글이 등록되었습니다.: %s', $event->article->title));
        }
    }
}
