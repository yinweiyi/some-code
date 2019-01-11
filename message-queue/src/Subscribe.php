<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11 0011
 * Time: 9:21
 */

namespace Wayee\MessageQueue;

class Subscribe extends Base
{
    /**
     * 订阅消息
     *
     * @param string $queueName
     * @param string $routeKey
     * @throws \ErrorException
     */
    public function receive($queueName = 'message', $routeKey = 'message')
    {
        $this->channel->queue_declare($queueName, false, false, false, false);

        $this->channel->basic_consume($routeKey, '', false, true, false, false, [$this, 'handle']);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    /**
     * 处理
     *
     * @param $msg
     */
    public function handle($msg)
    {
        $body = $msg->body;
        echo " [x] Received ", $body, "\n";

        $body = json_decode($body, true);

        //TODO   根据参数处理不同队列 继承此类并重写此方法
        print_r($body);
    }
}