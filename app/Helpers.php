<?php

if (!function_exists('markdown')) {
    function markdown($text)
    {
        return app(ParsedownExtra::class)->text($text);
    }
}

if (!function_exists('ddClass')) {
    function ddClass()
    {
//        return dd(get_parent_class() . ':' );
    }
}

