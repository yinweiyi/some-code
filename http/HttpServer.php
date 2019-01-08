<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26 0026
 * Time: 16:21
 */

use \Swoole\Http\Request;
use \Swoole\Http\Response;

require __DIR__ . '/../connectPool/RedisPool.php';
require __DIR__ . '/../connectPool/MysqlPool.php';

class HttpServer
{

    protected $host = '192.168.0.66';
    protected $post = '9501';

    /**
     * @var \Swoole\Http\Server
     */
    protected $server;

    public function __construct()
    {
        $this->server = new \Swoole\Http\Server($this->host, $this->post);
    }

    public function run()
    {
        $this->set([
            'http_compression' => true,
        ]);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->start();
    }

    public function set($array)
    {
        $this->server->set($array);
    }

    /**
     * request
     *
     * @param Request $request
     * @param Response $response
     */
    public function onRequest(Request $request, Response $response)
    {
        $response->header('Content-Type', 'text/html;charset=utf-8');

        $t1 = microtime(true);


        $db = new Co\MySQL();

        $db->connect([
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'homestead',
            'password' => 'secret',
            'database' => 'test_swoole',
        ]);

        $result = $db->query("insert into test(c1, c2) values ('t3', 3)");
        var_dump($result);

        $t2 = microtime(true);

        $response->end('耗时' . round($t2 - $t1, 3) . '秒');

        /*$client = new \Swoole\Client(SWOOLE_TCP);
        $client->connect('127.0.0.1', '9508');
        $sql = 'select  * from users where id = 1';
        $client->send($sql);
        $result = $client->recv();
        $data = json_decode($result, true);
        $client->close();
        $response->end(json_encode($data));*/


        /*$redisPool = new RedisPool();

        $redis = $redisPool->get();
        $value = $redis->get('key');
        $response->end('key:' . $value);*/

        /*$mysqlPool = new MysqlPool();
        $mysql = $mysqlPool->get();

        $id = $request->get['id'] ?: 1;
        $stmt = $mysql->prepare('select * from users where id=?');

        $result = $stmt->execute([$id]);

        $mysqlPool->put($mysql);
        $response->end(json_encode($result) . PHP_EOL . $mysqlPool->length());*/

    }

}


$server = new HttpServer();
$server->run();