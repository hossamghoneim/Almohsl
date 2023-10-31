<?php

if (!function_exists('isNavTabActive')) {

    function isNavTabActive($path) : string
    {
        if (request()->segment(1) == null && $path == "/")
            return 'active';
        else if (request()->segment(1) === $path)
            return 'active';
        else
            return '';
    }
}
