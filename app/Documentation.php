<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use File;

class Documentation
{
    public function get($file='documentation.md')
    {
//        dd($file);
        $file = is_null($file) ? 'documentation.md' : $file;
        $content = File::get($this->path($file));
        return $this->replaceLink($content);

    }
    protected function path($file)
    {
        $file = ends_with($file, '.md') ? $file : $file . '.md';
        $path = base_path('docs'. DIRECTORY_SEPARATOR . $file);
        if (! File::exists($path)) {
            abort('404', '요청하신 파일이 없습니다.');
        }
        return $path;
    }
    protected function replaceLink($content)
    {
        return str_replace('/docs/{{version}}', '/docs', $content);
    }
}
