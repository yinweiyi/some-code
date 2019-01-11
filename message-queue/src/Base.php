<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11 0011
 * Time: 13:58
 */

namespace Wayee\MessageQueue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Base
{

    /**
     * channels
     *
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * host
     *
     * @var string
     */
    protected $host = 'localhost';

    /**
     * port
     * @var int
     */
    protected $port = 5672;

    /**
     * user
     *
     * @var string
     */
    protected $user = 'guest';

    /**
     * password
     *
     * @var string
     */
    protected $pwd = 'guest';

    /**
     * 创建频道
     */
    public function __construct()
    {
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pwd);
        $this->channel = $connection->channel();
    }
}