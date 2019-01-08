<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/24 0024
 * Time: 17:49
 */

$queue = new SplQueue();

$queue->push('a');
$queue->push('b');
$queue->push('c');


echo $queue->pop();

echo $queue->count();