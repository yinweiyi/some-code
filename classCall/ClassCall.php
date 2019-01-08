<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/7 0007
 * Time: 14:13
 */

class ClassCall
{

    public function hello($name)
    {

        echo 'Hello:' . $name;
    }

    public function getName($name, $age)
    {
        echo 'name:' . $name . ' age:' . $age;
    }
}

class Call
{

    public function __call($name, $arguments)
    {

        $classCall = new ClassCall();

        $classCall->$name(...$arguments);
    }
}

$call = new Call();

$call->getName('张三' , 9);