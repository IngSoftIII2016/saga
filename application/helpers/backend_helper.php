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

    function format_error($title, $detail, $data = null) {
        $error = [
            'error' => [
                'title' => $title,
                'detail' => $detail
            ]];
        if($data) $error['data'] = $data;
        return $error;
    }

}

if(!function_exists('validate_not_empty'))
{
    function validate_not_empty($string) {
        return trim($string) == "" ? NULL : $string;
    }
}