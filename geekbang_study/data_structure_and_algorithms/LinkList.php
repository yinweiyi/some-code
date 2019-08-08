<?php

class Node
{
    public $data;
    public $next;
    public $prev;

    public function __construct($data)
    {
        $this->data = $data;
        $this->next = null;
        $this->prev = null;
    }

    /**
     * 获取前一个数据
     *
     * @return null
     */
    public function prev()
    {
        return $this->prev;
    }

    /**
     * 获取后一个数据
     *
     * @return null
     */
    public function next()
    {
        return $this->next;
    }
}


class LinkList
{
    //链表头节点
    private $header;

    /**
     * LinkList constructor. 初始化首个节点
     * @param null $data
     */
    public function __construct($data = null)
    {
        $this->header = new Node($data);
    }

    /**
     * 获取长度
     *
     * @return int
     */
    public function getLength()
    {
        $current = $this->header;
        $length = 0;
        while ($current->next != null) {
            $length++;
            $current = $current->next;
        }
        return $length;
    }


    /**
     * 添加节点
     *
     * @param Node $node
     */
    public function addNode(Node $node)
    {
        $current = $this->header;
        while ($current->next != null) {
            $current = $current->next;
        }
        $current->next = $node;
    }

    /**
     * 删除节点
     *
     * @param $id
     */
    public function delNode($id)
    {
        $current = $this->header;
        $index = 0;
        while ($current->next != null) {
            if ($index == $id) {
                $current->next = $current->next->next;
                break;
            }
            $current = $current->next;
            $index++;
        }
    }

    /**
     * 更新
     *
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $current = $this->header;
        $index = 0;
        while ($current->next != null) {
            if ($index == $id) {
                $current->next->data = $data;
                break;
            }
            $current = $current->next;
            $index++;
        }
    }

    /**
     * 获取节点
     *
     * @param $id
     * @return null
     */
    public function getNode($id)
    {
        $current = $this->header;
        $index = 0;
        while ($current->next != null) {
            $current = $current->next;
            if ($index == $id) {
                return $current;
            }

            $index++;
        }
        return null;
    }

    /**
     * 删除最后一个节点
     */
    public function pop()
    {
        $current = $this->header;
        while ($current->next != null) {
            if ($current->next->next == null) {
                $data = $current->next->data;
                $current->next = null;
                return $data;
            }
            $current = $current->next;
        }
        return null;
    }

    /**
     * 头插入
     *
     * @param Node $node
     */
    public function unshift(Node $node)
    {
        $current = $this->header;

        $node->next = $current->next;

        $this->header->next = $node;
    }

    /**
     * 链表反转(重新赋值)
     */
    public function reverse()
    {
        $current = $this->header;

        $temp = new self();
        while ($current->next != null) {
            $current = $current->next;
            $temp->unshift(new Node($current->data));
        }

        $this->header = $temp->header;
    }

    /**
     * 链表反转
     */
    public function reverse1()
    {
        //记录上一个
        $prev = null;
        $current = $this->header->next;
        while ($current) {
            $next = $current->next;
            $current->next = $prev;
            $this->header->next = $current;
            $prev = $current;
            $current = $next;
        }
    }

    /**
     * 打印
     */
    public function getNodeList()
    {
        $current = $this->header;
        $result = [];
        while ($current->next != null) {
            $current = $current->next;
            $result[] = [
                'data' => $current->data
            ];
        }
        return $result;
    }


    /**
     * 转换成双向
     */
    public function toDouble()
    {
        $current = $this->header->next;

        $prev = null;
        while ($current != null) {
            $current->prev = $prev;
            $prev = $current;
            $current = $current->next;
        }
    }

}

$linkList = new LinkList();
$linkList->addNode(new Node('ab1'));
$linkList->addNode(new Node('ab2'));
$linkList->addNode(new Node('ab3'));
$linkList->addNode(new Node('ab4'));

$linkList->toDouble();

$current = $linkList->getNode(3);

var_dump($current->prev()->prev()->prev()->next()->data);

