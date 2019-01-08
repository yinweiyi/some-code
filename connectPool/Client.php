<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4 0004
 * Time: 17:45
 */


$t1 = microtime(true);
connectMysqlNoPool(100);
$t2 = microtime(true);
echo '耗时' . round($t2 - $t1, 3) . '秒';


function connectMysqlByPool($count)
{
    $client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
    $rts = $client->connect('127.0.0.1', 9508, 10) or die("连接失败");//链接mysql客户端
    $sql = 'select  * from clients_2018_12_23 where id = 39710';
    $result = null;
    for ($i = 0; $i < $count; $i++) {
        $client->send($sql);
        $result = $client->recv();
    }
    return $result;
}

function connectMysqlNoPool($count)
{
    $mysql = new mysqli('192.168.0.66', 'homestead', 'secret', 'tcp_admin', '3306');
    for ($i = 0; $i < $count; $i++) {
        $sql = 'select  * from clients_2018_12_23 where id = 39710';
        $result = $mysql->query($sql);
    }
}

