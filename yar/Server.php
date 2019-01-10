<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 15:27
 */

class Server
{
    /**
     * the doc info will be generated automatically into service info page.
     * @params
     * @return
     */
    public function say($parameter, $option = "foo")
    {
        sleep(1);
        return $parameter;
    }

    public function write($parameter, $option = "foo")
    {
        return $parameter;
    }
}

$service = new Yar_Server(new Server());
$service->handle();
?>