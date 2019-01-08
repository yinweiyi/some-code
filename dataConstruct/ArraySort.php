<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8 0008
 * Time: 11:08
 */

$data = [
    'a' => ['value' => '1', 'sort' => 1],
    'b' => ['value' => '5', 'sort' => 3],
    'c' => ['value' => '3', 'sort' => 5],
    'd' => ['value' => '6', 'sort' => 7],
    'e' => ['value' => '7', 'sort' => 9],
    'f' => ['value' => '3', 'sort' => 8],
];

function one($data)
{
    $sorts = array_column($data, 'sort');

    array_multisort($sorts, SORT_DESC, $data);

    return $data;
}


function two($array, $key = 'sort', $sort = 'desc')
{
    uasort($array, function($a, $b) use ($key, $sort) {
        return  $sort == 'desc' ? $b[$key] - $a[$key] : $a[$key] - $b[$key];
    });

    return $array;
}

function three ($array, $key = 'sort', $sort = 'desc') {
    $keys = [];
    foreach ($array as $k => $item) {
        $keys[$k] = $item[$key];
    }

    $sort == 'desc' ? arsort($keys) : asort($keys);

    $newArray = [];
    foreach ($keys as $key => $item) {
        $newArray[$key] = $array[$key];
    }

    return $newArray;
}






