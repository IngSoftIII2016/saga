<?php

if(!function_exists('array_check_key'))
{

    function array_check_key($key, $array)
    {
        return (isset($array[$key]));
    }

}