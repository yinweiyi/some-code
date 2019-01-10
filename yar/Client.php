<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 15:32
 */

/*$client = new Yar_Client("http://test.test/yar/Server.php");

print_r($client->say(['hello', 'world']));*/


function callback($retval, $callinfo) {

    var_dump($callinfo);
    print_r($retval . PHP_EOL);

}

Yar_Concurrent_Client::call("http://test.test/yar/Server.php", "say", array("hello"), "callback");
Yar_Concurrent_Client::call("http://test.test/yar/Server.php", "write", array("world"), "callback");
Yar_Concurrent_Client::call("http://test.test/yar/Server.php", "say", array("hello"), "callback");
Yar_Concurrent_Client::call("http://test.test/yar/Server.php", "write", array("world"), "callback");
Yar_Concurrent_Client::loop(); //send