<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26 0026
 * Time: 18:25
 */


$t1 = microtime(true);
$workers = [];
for ($i = 0; $i < 6; $i++) {
    $process = new swoole_process(function (swoole_process $pro) {
        sleep(1);
        $pro->write('content' . PHP_EOL);
    }, true);

    $pid = $process->start();
    $workers[$pid] = $process;
}
$t2 = microtime(true);


foreach ($workers as $worker) {
    echo $worker->read();
}



