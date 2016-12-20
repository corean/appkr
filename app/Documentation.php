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

    /**
     * Generate path of the given file.
     *
     * @param string $file
     * @param string $dir
     * @return string $path
     */
    protected function path($file, $dir = 'docs')
    {
        $file = ends_with($file, ['.md', '.png']) ? $file : $file . '.md';
        $path = base_path($dir . DIRECTORY_SEPARATOR . $file);
        debug('path: ' . $path);
        if (! File::exists($path)) {
            abort('404', '요청하신 파일이 없습니다.');
        }
        return $path;
    }
    protected function replaceLink($content)
    {
        return str_replace('/docs/{{version}}', '/docs', $content);
    }

    /**
     * @param string $file
     * @return \Intervention\Image\Image
     */
    public function image($file)
    {
        return \Image::make($this->path($file, 'docs/images'));
    }

    /**
     * Generate ETag
     * @param string $file
     * @return md5
     */
    public function etag($file)
    {
        $lastModified = File::lastModified($this->path($file, 'docs/images'));
        return md5($file . $lastModified);
    }
}
