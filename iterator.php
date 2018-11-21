<?php

/**
 * 迭代器模式
 * 意图：
 *   提供一种方法顺序访问一个聚合兑现中的各个元素，而又无需暴露该对象的内部显示
 * 主要解决：
 *   不同的方式来遍历整个整合对象
 * 何时使用：
 *   遍历一个聚合对象
 * 如何解决：
 *   把在元素之间游走的责任交给迭代器，而不是聚合对象
 * 关键代码：
 *   定义接口 hasNext,next
 * 优点：
 *   支持不同的方式遍历一个聚合对象
 *   迭代器简化了聚合类
 *   在同一个聚合上可以有多个遍历
 *   在迭代器模式中添加新的聚合类和迭代器类痘痕方便，无需修改原有代码
 * 使用场景：
 *   访问一个聚合对象的内容而无需暴露它的内部表示
 *   需要为聚合对象提供多种遍历方式
 *   为遍历不同的聚合结构提供了统一的接口
 * 注意事项：
 *  迭代器模式就是分离了集合对象的遍历行为，抽象出一个迭代器类来负责，这样既可以做到不暴露集合的内部结构，又可让外部代码透明地访问集合内部的数据
 *   
 */

/**
 * 1:迭代器接口
 */
interface MyIterator{
  // 函数将内部指针设置回数据开始处
  public function rewind();

  // 函数将判断数据指针的当前位置是否还有更多的数据
  public function valid();

  // 函数返回数据指针的值
  public function key();

  // 函数返回当前指针对应数据的值
  public function value();

  // 函数在数据中移动数据指针的位置
  public function next();
}

/**
 * 2:实例化迭代器
 */
class ObjectIterator implements MyIterator{
  // 对象
  private $obj;

  // 数据元素的数量
  private $count;

  // 当前指针
  private $current;

  public function __construct($obj){
    $this->obj = $obj;
    $this->count = count($this->obj->data);
  }

  public function rewind(){
    $this->current = 0;
  }

  public function valid(){
    return $this->current < $this->count;
  }

  public function key(){
    return $this->current;
  }

  public function value(){
    return $this->obj->data[$this->current];
  }

  public function next(){
    $this->current ++;
  }
}

/**
 * 3:获取迭代器接口
 */
interface MyAggregate{
  public function getIntegrator();
}

/**
 * 4:实例化
 */
class MyObject implements MyAggregate{
  public $data = [];

  public function __construct($in){
    $this->data = $in;
  }

  public function getIntegrator(){
    return new ObjectIterator($this);
  }
}

// 客户端
$arr = [2,4,6,8,10];
$myObject = new MyObject($arr);
$myIterator = $myObject->getIntegrator();
// 初始化
$myIterator->rewind();
while ($myIterator->valid()) {
  $key = $myIterator->key();
  $value = $myIterator->value();
  echo $key.'=>'.$value;
  echo PHP_EOL;

  $myIterator->next();
}
var_dump($myIterator);

