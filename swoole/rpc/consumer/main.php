<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 14:38
 */

define("SERVER_IP", "127.0.0.1");
define("SERVER_PORT", 9503);
define("SOA_SERVER_PORT", 9504);

include __DIR__."/RpcClient.php";

$http = new swoole_http_server(SERVER_IP, SERVER_PORT);

$http->on("start", function ($server) {
    echo "http server is started at http://" . SERVER_IP . ":" . SERVER_PORT . "\n";
    registerService(null, ["UserService"]);
});

$http->on("request", function ($request, $response) {
    $userService = new Client('UserService');
    $res = $userService->getUserInfo(103);
    $response->header("Content-Type", "text/plain");
    $response->end(var_export($res,true));
});


$http->start();

/**
 * @param array $provider 提供服务
 * @param array $consumer 服务消费
 * @return array
 */
function registerService($provider, $consumer)
{
    $content = json_encode(['provider' => $provider, 'consumer' => $consumer]);
    $options['http'] = [
        'timeout' => 5,
        'method'  => 'POST',
        'header'  => 'Content-type:application/x-www-form-urlencoded',
        'content' => $content,
    ];

    $context = stream_context_create($options);

    $url = "http://127.0.0.1:9510";

    $res = file_get_contents($url, false, $context);

    $res = json_decode($res, true);

    if ($res){
        foreach ($res as $service => $socket){
            file_put_contents(__DIR__."/provider/".$service,$socket);
        }
    }
}