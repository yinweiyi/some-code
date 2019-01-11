<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11 0011
 * Time: 10:44
 */

namespace Wayee\MessageQueue\Messages;

class Message
{

    protected $accessKeyId;
    protected $accessKeySecret;


    public function send($phone, $code, $signName, $templateCode)
    {

    }

}