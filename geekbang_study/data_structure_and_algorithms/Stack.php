<?php


class Stack
{
    //数据
    private $items = [];

    //长度
    private $length = 5;

    //当前数量
    private $count = 0;

    /**
     * 入栈
     *
     * @param $data
     * @return bool
     */
    public function push($data)
    {
        if ($this->count >= $this->length) {
            return false;
        }

        $this->items[$this->count++] = $data;
    }

    /**
     * 出栈
     *
     * @return mixed|null
     */
    public function pop()
    {
        if ($this->count == 0) {
            return null;
        }
        $item = $this->items[$this->count - 1];

        unset($this->items[$this->count - 1]);

        $this->count--;

        return $item;
    }

    /**
     * @return mixed|null
     */
    public function getPopItem()
    {
        return $this->items[$this->count - 1] ?? null;
    }

    /**
     * 获取栈
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * 清空
     */
    public function clear()
    {
        $this->items = [];
        $this->count = 0;
    }
}

class Chrome
{
    /**
     * @var Stack 历史
     */
    private $history;

    /**
     * @var Stack 未来
     */
    private $future;

    public function __construct(Stack $history, Stack $future)
    {
        $this->history = $history;
        $this->future = $future;
    }


    /**
     * 新地址
     *
     * @param $url
     * @return mixed
     */
    public function newUrl($url)
    {
        $this->history->push($url);
        $this->future->clear();
        return $url;
    }

    /**
     * 前进
     *
     * @return mixed|null
     */
    public function forward()
    {
        $url = $this->future->pop();

        if (!$url) return null;

        $this->history->push($url);

        return $url;
    }

    /**
     * 后退
     *
     * @return mixed|null
     */
    public function back()
    {
        $url = $this->history->pop();

        if (!$url) return null;

        $this->future->push($url);

        return $this->history->getPopItem();
    }
}


//模拟浏览器前进后退

$history = new Stack();
$future = new Stack();

$chrome = new Chrome($history, $future);

$chrome->newUrl('http://www.baidu.com');
$chrome->newUrl('http://www.baidu1.com');
$chrome->newUrl('http://www.baidu2.com');
$chrome->newUrl('http://www.baidu3.com');

$chrome->back();
$chrome->back();
$chrome->forward();
echo $chrome->forward();