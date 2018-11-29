<?php

/**
 * 链表
 */

/**
 * 定义链表节点
 */
class Node{
  // 节点数据
  public $data;
  // 后继指针
  public $next;
  // 初始化
  public function __construct($data = null){
    $this->data = $data;
    $this->next = null;
  }
}

/**
 * 定义单链表
 */
class SingleLinkedList{
  // 头节点
  public $head;
  // 长度
  public $length;
  // 初始化
  public function __construct($head = null){
    $this->head = is_null($head) ? new Node() : $head;
    $this->length = 0;
  }
  /**
   * 查询数据
   * @param   Int $data 
   * @return  obj $node
   */
  public function findNode(Int $data){
    if(is_null($this->head->next)) return false;
    $node = $this->head;
    while (!is_null($node) && $node->data != $data) {
      $node = $node->next;
    }
    if($node->data != $data) return false;
    return $node;
  } 

  /**
   * 获取某个节点的前置节点
   * @param Int $data
   * @return   2表示$data 不存在
   */
  public function getPreNode(Int $data){
    $node = $this->head;
    while (!is_null($node->next) && $node->data != $data) {
      // 定义前置节点
      $preNode = $node;
      $node = $node->next;
    }
    if($node->data != $data) return false;
    return ['node'=>$node,'preNode'=>$preNode];
  }

  /**
   * 插入数据-头插法：每次都插入到哨兵节点后
   * @return  bool 
   */
  public function headInsert(Int $data){
    $newNode = new Node($data);
    if(is_null($this->head->next)){
      $this->head->next = $newNode;
    }else{
      $newNode->next = $this->head->next;
      $this->head->next = $newNode;
    }
    $this->length ++;
    return true;
  }

  /**
   * 插入数据-尾插法：每次都插入链表的尾部
   * @param   $data 节点的值
   * @return  bool 
   */
  public function tailInsert(Int $data){
    $newNode = new Node($data);
    // 找到尾节点
    $tailNode = $this->head;
    while (!is_null($tailNode->next)) {
      $tailNode = $tailNode->next;
    }
    $tailNode->next = $newNode;
    $this->length++;
    return true;
  }

  /**
   * 在给定的数据后插入新数据
   * @param  $originData 链表中的数据
   * @param  $data       要插入的数据
   * @return 1 数据不存在 0插入成功
   */
  public function afterInsert(Int $originData,Int $data){
    $node = $this->head;
    while (!is_null($node->next) && $node->data != $originData) {
      $node = $node->next;
    }
    if($node->data != $originData) return 1;
    $newNode = new Node($data);
    $newNode->next = $node->next;
    $node->next = $newNode;
    $this->length ++;
    return 0; 
  }

  /**
   * 删除节点
   * 1找到这个节点的前置节点 
   * 2改变前置节点的next指向
   * 3unset去掉的节点
   * @param  int $data 节点的值
   * @return 0:删除成功 1：头节点为空 2:$data 不存在对应的节点
   */
  public function delete(Int $data){
    if(is_null($this->head->next)) return 1;
    // 获取前置节点
    $nodes = $this->getPreNode($data);
    if(!$nodes) return 2;
    $node = $nodes['node'];
    $preNode = $nodes['preNode'];
    $preNode->next = $node->next;
    unset($node);
    $this->length --;
    return 0;
  }

  /**
   * 获取尾元素值
   */
  public function getLastData(){
    if(is_null($this->head->next)) return false;
    $node = $this->head;
    while (!is_null($node->next)) {
      $node = $node->next;
    }
    return $node->data;
  }

  /**
   * 输出单链表
   */
  public function printList(){
    if(is_null($this->head->next)) return false;
    // 声明循环开始节点
    $node = $this->head->next;
    $i = 0;
    while ($i < $this->length) {
      echo $node->data.'->';
      $node = $node->next;
      $i++;
    }
  }

  /**
   * 单链表实现lru算法（least recently used）
   * 1. 如果此数据之前已经被缓存在链表中了，我们遍历得到这个数据对应的结点，并将其从原来的位置删除，然后再插入到链表的头部。
   * 2. 如果此数据没有在缓存链表中，又可以分为两种情况：
   *     如果此时缓存未满，则将此结点直接插入到链表的头部
   *     如果此时缓存已满，则链表尾结点删除，将新的数据结点插入链表的头部
   * @param    Int                         $data   插入的数据
   * @param    Int                         $length 限制lru链表的长度
   */
  public function lru(Int $data,Int $length){
    if(is_null($this->head->next)){
      $this->head->next = new Node($data);
      $this->length ++;
      return ;
    }
    $nodes = $this->getPreNode($data);
    if(!$nodes) return false;
    $node = $nodes['node'];
    $preNode = $nodes['preNode'];
    // 判断 链表中是否存在$data 对应的节点
    if($node->data != $data){
      $newNode = new Node($data);
      // 检测lru链表的长度是否超过最大值
      if($this->length >= $length){
        // 删除尾节点
        $this->delete($this->getLastData());
      }
      $newNode->next = $this->head->next;
      $this->head->next = $newNode;
      $this->length ++;
    }else{
      $preNode->next = $node->next;
      $node->next = $this->head->next;
      $this->head->next = $node;
    }
  }

  /**
   * 判断是否是回文字符串
   * 
   * 思路：寻找中间节点 （快慢指针法）
   */
  public function checkPalindrome(){
    // 回文字符串至少有两个元素
    if(is_null($this->head->next) || is_null($this->head->next->next)) return false;
    // 找中间节点 
    $fastNode = $this->head->next;
    $slowNode = $this->head->next;
    while (!is_null($fastNode->next->next)) {
      $fastNode = $fastNode->next->next;
      $slowNode = $slowNode->next;
    }
    if(!is_null($fastNode->next)){
      // 中间点偶数
      $leftNode = $slowNode;
      $rightNode = $slowNode->next;
    }else{
      // 中间点奇数
      $leftNode = $this->getPreNode($slowNode->data)['preNode'];
      $rightNode = $slowNode->next;
    }
    while (!is_null($rightNode->next) && !is_null($leftNode->data)) {
      if($leftNode->data != $rightNode->data) return false;
      $leftNode = $this->getPreNode($leftNode->data)['preNode'];
      $rightNode = $rightNode->next;
    }
    // 判断 左边没到头 右边没到底 首尾值不一致
    if(is_null($leftNode->data) || !is_null($rightNode->next) || $leftNode->data != $rightNode->data) return false;
    return true;
  }

  /**
   * 单链表反转
   * head->1->2->3->4->null
   * 
   * 思路
   *   head->1->null
   *   head->2->1->null
   *   head->3->2->1->null
   *   head->4->3->2->1->null
   *   第一次取出1->2->3->4,1的next指向null为1->null，preNode此时记为1->null， 剩余部分2->3->4 记为curNode
   *   第二次从curNode 2-3->4中 设置 2的next为第一步中preNode, 此时preNode记录为  2->1->null，剩余部分 3->4 记为新的curNode
   *   第三次从curNode 3->4中 设置 3的next为第二步中preNode,此时preNode记录为 3->2->1->null, 剩余部分 4 记为 4
   *   第四次从curNode 4 设置 4的next为第三部中preNode，此时preNode记为4->3->2->1->null,剩余null 极为新的curNode 
   *   curNode 为null 跳出循环 
   */
  public function reverse(){
    // 单链表反转 至少需要1个节点
    if(is_null($this->head) || is_null($this->head->next)) return false;
     // 反转后的链表
    $preNode = null;
    // 当前的链表
    $curNode = $this->head->next;
    // 记录剩下的链表 
    $remainNode = null;
    $this->head->next = null;
    while (!is_null($curNode)) {
      $remainNode = $curNode->next;
      // 取出当前链表的第一 node
      $curNode->next = $preNode;
      // 拼接反转后的链表
      $preNode = $curNode;
      $curNode = $remainNode;
    }
    // 拼接头节点
    $this->head->next = $preNode;
    $this->printList();
  }

  /**
   * 检测单链表是否有环
   *
   * 思路：快慢指针如果相遇 则有环
   */
  public function checkCircle(){
    if(is_null($this->head) || is_null($this->head->next)) return false;
    $fastNode = $this->head->next;
    $slowNode = $this->head->next;
    while (!is_null($fastNode) && !is_null($slowNode)) {
      if($fastNode->data == $slowNode->data) return true;
      $fastNode = $fastNode->next->next;
      $slowNode = $slowNode->next;
    }
    return false;
  }

  /**
   * deleteLastKth 删除链表倒数第n个结点
   *
   * 思路: 快慢指针
   *   快指针 先向前移动n步
   *   快慢指针同时向前移动，当快指针到尾部时，结束 (注意删除第一个节点这种特殊情况)
   */
  public function deleteLastKth(Int $k){
    if($k > $this->length) return false;
    if($k == $this->length) {
      // 删除第一个节点
      $this->head->next = $this->head->next->next;
    }else{
      $fastNode = $this->head->next;
      $slowNode = $this->head->next;
      $i = 0;
      while ($i < $k && !is_null($fastNode)) {
        $fastNode = $fastNode->next;
        $i++;
      }
      while (!is_null($fastNode->next)) {
        $fastNode = $fastNode->next;
        $slowNode = $slowNode->next;
      }
      $slowNode->next = $slowNode->next->next;
    }
    $this->length --;
    $this->printList();
  }
}

// 测试 创建单链表
$link1 = new SingleLinkedList();
$link1->tailInsert(1);
$link1->tailInsert(2);
$link1->tailInsert(3);
$link1->tailInsert(4);
$link1->printList();

// 查询节点
print_r($link1->findNode(3));
echo PHP_EOL;

// 删除节点
echo $link1->delete(1);
echo PHP_EOL;

// 在某个节点后插入数据
$link1->afterInsert(2,5);
echo PHP_EOL;

// 打印链表
$link1->printList();
echo PHP_EOL;

// 测试lru
$link2 = new SingleLinkedList();
$link2->lru(1,4);
$link2->lru(3,4);
$link2->lru(4,4);
$link2->lru(5,4);
$link2->lru(3,4);
$link2->printList();
echo PHP_EOL;

// 检测回文字符串
$string = '1,3,4,5,5,4,3,1';
$link3 = new SingleLinkedList();
$arr = explode(',', $string);
$countArr = count($arr);
$i = 0;
while ($i < $countArr) {
  $link3->tailInsert($arr[$i]);
  $i++;
}
var_dump($link3->checkPalindrome());
echo PHP_EOL;

// 测试单链表反转
$link3 = new SingleLinkedList();
$link3->tailInsert(1);
$link3->tailInsert(2);
$link3->tailInsert(3);
$link3->tailInsert(4);
$link3->reverse();
echo PHP_EOL;

// 测试删除第k个节点
$link3->deleteLastKth(4);
