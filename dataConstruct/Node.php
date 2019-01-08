<?php

class Node
{
    public $id;
    public $name;
    public $next;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->next = null;
    }
}

class SingleLinkList
{

    //链表头节点
    private $header;

    public function __construct($id = null, $name = null)
    {
        $this->header = new Node($id, $name);
    }

    /**
     * 获取链表长度
     *
     * @return int
     */
    public function getLength()
    {
        $length = 0;

        $current = $this->header;
        while ($current->next != null) {

            $current = $current->next;
            $length++;
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

            if ($current->next->id > $node->id) {
                break;
            }
            $current = $current->next;
        }

        $node->next = $current->next;
        $current->next = $node;
    }

    /**
     * 获取节点
     *
     * @param $id
     * @return string
     */
    public function getNode($id)
    {
        $current = $this->header;
        while ($current->next != null) {

            if ($current->next->id == $id) {

                return $current->next->name;
            }
            $current = $current->next;
        }

        return '未找到id为' . $id . '的节点';
    }

    /**
     * 获取链表
     *
     * @return array
     */
    public function getNodeList()
    {
        $current = $this->header;
        if ($current->next == null) {
            return [];
        }
        $nodes = [];

        while ($current->next != null) {
            $nodes[] = [
                'id' => $current->next->id,
                'name' => $current->next->name
            ];
            $current = $current->next;
        }

        return $nodes;
    }

    /**
     * 删除节点
     *
     * @param $id
     */
    public function delNode($id)
    {
        $current = $this->header;
        $flag = false;
        while ($current->next != null) {
            if ($current->next->id == $id) {
                $flag = true;
                break;
            }
            $current = $current->next;
        }
        if ($flag) {
            $current->next = $current->next->next;
        } else {
            echo '未找到id=' . $id . '的节点！<br>';
        }
    }

    /**
     * 更新节点
     *
     * @param $id
     * @param $name
     */
    public function updateNode($id, $name)
    {
        $current = $this->header;

        while ($current->next != null) {
            if ($current->id == $id) {
                break;
            }
            $current = $current->next;
        }
        $current->name = $name;
    }

    /**
     * 节点是否为空
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->header == null;
    }

    /**
     * 清空节点
     */
    public function clear()
    {
        $this->header = null;
    }
}

$lists = new SingleLinkList();
$lists->addNode(new Node (5, 'eeeeee'));
$lists->addNode(new Node (1, 'aaaaaa'));
$lists->addNode(new Node (6, 'ffffff'));
$lists->addNode(new Node (4, 'dddddd'));
$lists->addNode(new Node (3, 'cccccc'));
$lists->addNode(new Node (2, 'bbbbbb'));

//删除节点
$lists->delNode(3);
//更新节点
$lists->updateNode(2, 'bbbbbbb');

print_r($lists->getNodeList());