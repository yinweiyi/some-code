<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11 0011
 * Time: 13:58
 */

namespace Wayee\MessageQueue;


use PhpAmqpLib\Message\AMQPMessage;

class Publish extends Base
{

    /**
     * 发送
     *
     * @param $message
     * @param string $queueName
     * @param string $routeKey
     */
    public function send($message, $queueName = 'message', $routeKey = 'message')
    {

        if (!$message instanceof AMQPMessage) {
            $message = new AMQPMessage($message);
        }
        $this->channel->queue_declare($queueName, false, false, false, false);
        $this->channel->basic_publish($message, '', $routeKey);

        //发送完成后打印消息告诉发布消息的人：发送成功
        echo " [x] Sent '{$message->getBody()}'\n";

        //关闭连接
        $this->channel->close();
    }
}