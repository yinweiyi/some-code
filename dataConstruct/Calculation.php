<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8 0008
 * Time: 14:03
 */

function binary_search($array, $low, $high, $key)
{

    while ($low <= $high) {
        $mid = floor($low + $high) / 2;

        if ($key == $array[$mid]) {
            return $mid + 1;
        }

        if ($key < $array[$mid]) {
            $high = $mid - 1;
        } else if ($key > $array[$mid]) {
            $low = $mid + 1;
        }
    }
    return -1;
}