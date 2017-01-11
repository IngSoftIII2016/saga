<?php

if(!function_exists('array_check_key'))
{

    function array_check_key($key, $array)
    {
        return (isset($array[$key]));
    }

}

if(!function_exists('format_error'))
{

    function format_error($title, $detail) {
        return [
            'error' => [
                'title' => $title,
                'detail' => $detail
            ]
        ];
    }

}