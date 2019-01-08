<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/28 0028
 * Time: 10:32
 */

include './phprpc_3.0.1_php/php/phprpc_client.php';


$client =  new PHPRPC_Client('http://test.test/phprpc/server.php');

echo $client->hello('rpc');