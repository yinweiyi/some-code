<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 14:40
 */

define("SERVER_IP", "127.0.0.1");
define("SERVER_PORT", 9511);

$http = new swoole_http_server(SERVER_IP, SERVER_PORT);

$http->on("start", function ($server) {
    echo "http server is started at http://" . SERVER_IP . ":" . SERVER_PORT . "\n";
    registerService([
        ['service' => UserService::class,'ip' => SERVER_IP,'port' => SERVER_PORT]
    ], null);
});

$http->on("request", function ($request, $response) {
    $res = httpRequest($request);
    $response->header("Content-Type", "text/plain");
    $response->end($res);
});

$http->start();


function httpRequest($request)
{
    $service = $request->get['service'];
    $action = $request->get['action'];

    if (!isset($service) || !isset($action)) {
        return "";
    }

    $argv = $request->rawContent();

    if ($argv) {
        $argv = json_decode($argv, true);
    }

    $res = call_user_func_array([$service, $action], $argv);

    return json_encode($res);
}

class UserService
{
    public static function getUserInfo($uid)
    {
        // 假设以下内容从数据库取出
        return [
            'id'       => $uid,
            'username' => 'mengkang',
        ];
    }
}


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

    return json_decode($res, true);
}