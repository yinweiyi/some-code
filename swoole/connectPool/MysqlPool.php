<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26 0026
 * Time: 15:45
 */

class MysqlPool
{
    /**
     * @var \Swoole\Coroutine\Channel
     */
    protected $pool;

    /**
     * RedisPool constructor.
     * @param int $size 连接池的尺寸
     */
    function __construct($size = 10)
    {
        $this->pool = new Swoole\Coroutine\Channel($size);
        for ($i = 0; $i < $size; $i++) {
            $mysql = new Swoole\Coroutine\Mysql();

            $res = $mysql->connect([
                'host' => '127.0.0.1',
                'port' => 3306,
                'user' => 'homestead',
                'password' => 'secret',
                'database' => 'tcp_admin',
            ]);

            if ($res == false) {
                throw new RuntimeException("failed to connect mysql server.");
            } else {
                $this->put($mysql);
            }
        }
    }

    function put($mysql)
    {
        $this->pool->push($mysql);
    }

    /**
     * @return \Swoole\Coroutine\Mysql
     */
    function get()
    {
        if ($this->pool->length() == 0) {
            throw new RuntimeException("mysql server is busy..");
        }
        return $this->pool->pop();
    }

    /**
     * 获取长度
     *
     * @return int
     */
    public function length()
    {
        return $this->pool->length();
    }
}

