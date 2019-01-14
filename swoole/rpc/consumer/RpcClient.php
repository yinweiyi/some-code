<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 14:39
 */

class Client
{
    private $url;
    private $service;

    private $rpcConfig = [
        "UserService" => "http://127.0.0.1:8081",
    ];

    public function __construct($service)
    {
        if (file_exists(__DIR__."/provider/".$service)){
            $this->url = "http://".file_get_contents(__DIR__."/provider/".$service);
            $this->service = $service;
        }
    }

    public function __call($action, $arguments)
    {
        $content = json_encode($arguments);
        $options['http'] = [
            'timeout' => 5,
            'method'  => 'POST',
            'header'  => 'Content-type:application/x-www-form-urlencoded',
            'content' => $content,
        ];

        $context = stream_context_create($options);

        $get = [
            'service' => $this->service,
            'action'  => $action,
        ];

        $url = $this->url . "?" . http_build_query($get);
        echo $url."\n";

        $res = file_get_contents($url, false, $context);

        return json_decode($res, true);
    }
}