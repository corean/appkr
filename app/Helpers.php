<?php

if (!function_exists('markdown')) {
    function markdown($text)
    {
        return app(ParsedownExtra::class)->text($text);
    }
}