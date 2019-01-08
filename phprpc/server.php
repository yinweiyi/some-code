<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/28 0028
 * Time: 10:30
 */

include './phprpc_3.0.1_php/php/phprpc_server.php';

function hello($name)
{

    return 'hello : ' . $name;
}

$server = new PHPRPC_Server();

$server->add('hello');

$server->start();