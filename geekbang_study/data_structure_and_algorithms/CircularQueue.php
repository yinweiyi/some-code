<?php

/**
 * 环形队列
 *
 * Class CircularQueue
 */
class CircularQueue
{
    //队头下标
    private $head = 0;
    //队尾下标
    private $tail = 0;
    //队列数组
    private $items = [];
    //队列长度
    private $len = 4;
    //当前队列长度
    private $curlen = 0;

    /**
     * 入队
     *
     * @param String $item
     * @throws Exception
     */
    public function enqueue(String $item)
    {
        if ($this->curlen == $this->len) throw new \Exception('enqueue is full');

        $this->items[$this->tail] = $item;

        $this->tail = $this->tail == $this->len - 1 ? 0 : $this->tail + 1;

        $this->curlen++;
    }

    /**
     * 出队
     *
     * @return bool
     * @throws Exception
     */
    public function dequeue()
    {
        //无队列时
        if ($this->curlen == 0) throw new \Exception('enqueue is empty');

        $item = $this->items[$this->head];

        $this->head = $this->head == $this->len - 1 ? 0 : $this->head + 1;

        $this->curlen--;

        return $item;
    }

    /**
     * 获取队列
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

}

$queue = new CircularQueue();

$queue->enqueue('1');
$queue->enqueue('2');
$queue->enqueue('3');
$queue->enqueue('4');
var_dump($queue->dequeue());
$queue->enqueue('5');


var_dump($queue->getItems());
