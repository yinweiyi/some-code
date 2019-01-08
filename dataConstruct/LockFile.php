<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/18 0018
 * Time: 10:10
 */

function writeData($filePath, $data)
{
    $fa = fopen($filePath, 'a');

    do {
        usleep(100);
    } while (!flock($fa, LOCK_EX));

    fwrite($fa, $data);
    flock($fa, LOCK_UN);
    fclose($fa);
}