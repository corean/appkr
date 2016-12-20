<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

class DocsController extends Controller
{
    protected $docs;

    public function __construct(\App\Documentation $docs)
    {
        $this->docs = $docs;
    }

    /**
     * Display the specified resource.
     *
     * @param string /null $file
     * @return \Illuminate\Http\Response
     */
    public function show($file = null)
    {
        $index = \Cache::remember('docs.index', 120, function () {
            return markdown($this->docs->get());
        });
//        debug('$file-1: ' . $file);
        $content = \Cache::remember("docs.{$file}", 120, function () use ($file) {
            debug('$file-2: ' . $file ?: 'installation.md');
            return markdown($this->docs->get($file ?: 'installation.md'));
        });
        return view('docs.show', compact('index', 'content'));
    }

    /**
     * @param string $file
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function image($file)
    {
        $reqEtag = \Request::getEtags();
        $genEtag = $this->docs->etag($file);

//        debug('$reqEtag: ' . $reqEtag);
//        debug('$genEtag: ' . $genEtag);

        if (isset($reqEtag[0])) {
            if ($reqEtag[0] === $genEtag) {
                return response('', 304);
            }
        }

        $image = $this->docs->image($file);
        return response($image->encode('png'), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=0',
            'Etag' => $genEtag,
        ]);
    }
}
