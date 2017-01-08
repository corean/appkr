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

if (!function_exists('gravatar_url')) {
    function gravatar_url($email, $size = 48)
    {
        return sprintf('//www.gravatar.com/avatar/%s?s=%s', md5($email), $size);
    }
}

if (!function_exists('gravatar_profile_url')) {
    function gravatar_profile_url($email)
    {
        return sprintf('//www.gravatar.com/%s', md5($email));
    }
}



