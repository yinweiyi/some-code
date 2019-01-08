<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4 0004
 * Time: 17:16
 */

class Server
{

    //swoole地址
    protected $swooleHost = '127.0.0.1';
    //swoole商品
    protected $swoolePort = '9508';
    //Task进程的数量
    protected $taskWorkerNum = 2;
    //worker数量
    protected $workerNum = 5;
    //最大连接数量
    protected $maxRequestNum = 10000;
    //数据包分发策略  固定模式
    protected $dispatchModel = 2;
    //非守护进程
    protected $daemonize = 0;


    protected $db_host = '192.168.0.66';
    protected $db_user = 'homestead';
    protected $db_pwd = 'secret';
    protected $db_name = 'tcp_admin';
    protected $db_port = '3306';

    /**
     * @var swoole_server|null
     */
    protected $server = null;


    public function __construct()
    {
        $this->server = new swoole_server($this->swooleHost, $this->swoolePort);

        $this->server->set([
            'worker_num' => $this->workerNum,
            'task_worker_num' => $this->taskWorkerNum,
            'max_request' => $this->maxRequestNum,
            'daemonize' => $this->daemonize,
            'dispatch_mode' => $this->dispatchModel,
        ]);

    }

    /**
     * 启动server
     */
    public function run()
    {
        $this->server->on('Receive', [$this, 'receive']);
        $this->server->on('Task', [$this, 'task']);
        $this->server->on('Finish', [$this, 'finish']);

        $this->server->start();
    }


    /**
     * 接收mysql查询
     *
     * @param $server
     * @param $fd
     * @param $from_id
     * @param $data
     */
    public function receive($server, $fd, $from_id, $data)
    {
        $result = $this->server->taskwait($data);

        if ($result != false) {
            $result = json_decode($result, true);
            if ($result['status'] == 'OK') {
                $this->server->send($fd, json_encode($result['data']));
            } else {
                $this->server->send($fd, $result);
            }
            return;
        } else {
            $this->server->send($fd, "Error. Task timeout\n");
        }
    }

    /**
     * 任务
     *
     * @param $serv
     * @param $task_id
     * @param $from_id
     * @param $sql
     */
    public function task($serv, $task_id, $from_id, $sql)
    {
        static $link = null;

        HELL:
        if ($link == null) {
            $link = @mysqli_connect($this->db_host, $this->db_user, $this->db_pwd, $this->db_name, $this->db_port);
            if (!$link) {
                $link = null;
                $this->server->finish("ER:" . mysqli_error($link));
                return;
            }
        }

        $result = $link->query($sql);

        if (!$result) {
            if (in_array(mysqli_errno($link), [2013, 2006])) {//错误码为2013，或者2006，则重连数据库，重新执行sql
                $link = null;
                goto HELL;
            } else {
                $this->server->finish("ER:" . mysqli_error($link));
                return;
            }
        }

        if (preg_match("/^select/i", $sql)) {
            //如果是select操作，就返回关联数组
            $data = array();
            while ($fetchResult = mysqli_fetch_assoc($result)) {
                $data['data'][] = $fetchResult;
            }
        } else {//否则直接返回结果
            $data['data'] = $result;
        }
        $data['status'] = "OK";
        $this->server->finish(json_encode($data));
    }

    public function finish()
    {
        echo "任务完成";//taskwait  不触发这个函数。。
    }
}

$server = new Server();
$server->run();