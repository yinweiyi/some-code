<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 14:40
 */

define("SERVER_IP", "127.0.0.1");
define("SERVER_PORT", 9510);

$http = new swoole_http_server(SERVER_IP, SERVER_PORT);

$http->on("start", function ($server) {
    echo "http server is started at http://" . SERVER_IP . ":" . SERVER_PORT . "\n";
});

$http->on("request", function ($request, $response) {
    $res = httpRequest($request);
    $response->header("Content-Type", "text/plain");
    $response->end($res);
});

$http->start();

/**
 * [
 * 'provider' => [
 * [
 * 'ip' => 'xxx',
 * 'port' => 'xxx',
 * 'service' => 'xxx',
 * ]
 * ],
 * 'coumser' => [
 * 'UserService'
 * ],
 * ];*/

function httpRequest($request)
{
    $argv = $request->rawContent();

    if ($argv) {
        $argv = json_decode($argv, true);
    }

    if (isset($argv['provider'])) {
        foreach ($argv['provider'] as $provider) {
            // 入库
            file_put_contents(__DIR__ . "/provider/list",
                sprintf("%s,%s,%s\n", $provider['service'], $provider['ip'], $provider['port']),
                FILE_APPEND);
        }
    }

    $list = file(__DIR__ . "/provider/list");

    $providers = [];
    foreach ($list as $item) {
        $tmp = explode(",", $item);
        $service = array_shift($tmp);
        $providers[$service] = trim(join(":", $tmp));
    }

    $res = [];
    if (isset($argv['consumer'])) {
        foreach ($argv['consumer'] as $item) {
            if (isset($providers[$item])) {
                $res[$item] = $providers[$item];
            }
        }
    }

    return json_encode($res);
}