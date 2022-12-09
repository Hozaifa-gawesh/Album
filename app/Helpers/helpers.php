<?php


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

if(!function_exists('str_limit')) {
    function str_limit($string, $length = 100, $end = '...'): string
    {
        return Str::limit($string, $length, $end);
    }
}


if(!function_exists('flash')) {
    function flash(string $type, string $message)
    {
        return Session::flash($type, $message);
    }
}
