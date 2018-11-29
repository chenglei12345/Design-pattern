<?php

/**
 * @Author   chenglei<1224936226@qq.com>
 * @DateTime 2018-11-28
 * 数组
 * 
 * 概念：数组（Array）是一种线性表数据结构。它用一组连续的内存空间，来存储一组具有相同类型的数据。
 * 特点：能够实现随机访问，根据下标随机访问的时间复杂度为 O(1)
 *
 */

/**
 * 简单数组类
 */
class MyArray{
  // 数据
  private $data;
  // 容量
  private $capacity;
  // 长度
  private $length;

  // 初始化数组
  public function __construct($capacity){
    $capacity = intval($capacity);
    if($capacity <= 0) return null;
    $this->capacity = $capacity;
    $this->data = [];
    $this->length = 0;
  }

  /**
   * 检查数组是否已满 
   * @return   bool
   */
  public function checkIfFull(){
    if($this->length == $this->capacity){
      return true;
    }
    return false;
  }

  /**
   * 检测数组索引index 是否已越界
   * @return  bool 
   */
  public function checkOutOfRange($index){
    if($index > $this->length+1){
      return true;
    }
    return false;
  }
  
  /**
   * 在索引index位置插入值value，返回错误码，0为插入成功
   * @param $index
   * @param $value
   * @return int
   */
  public function insert($index,$value){
    $index = intval($index);
    $value = intval($value);
    if($index < 0) {
      return 1;
    }
    if($this->checkIfFull()) {
      return 2;
    }
    if($this->checkOutOfRange($index)) {
      return 3;
    }

    for($i=$this->length-1;$i>=$index;$i--) {
      $this->data[$i+1] = $this->data[$i];
    }

    $this->data[$index] = $value;
    $this->length++;
    return 0;
  }

  /**
   * 删除索引index上的值，并返回
   * @param $index
   * @return array
   */
  public function delete($index){
    $value = 0;
    $index = intval($index);
    if($index < 0) {
      $code = 1;
      return array($code, $value);
    }
    if($index != $this->length+1 && $this->checkOutOfRange($index)) {
      $code = 2;
      return array($code, $value);
    }

    $value = $this->data[$index];
    for($i=$index;$i<$this->length-1;$i++) {
      $this->data[$i] = $this->data[$i+1];
    }

    $this->length--;
    return array(0, $value);
  }

  /**
   * 查找索引index的值
   * @param $index
   * @return array
   */
  public function find($index){
    $value = 0;
    $index = intval($index);
    if($index < 0) {
      // 声明错误码
      $code = 1;
      return array($code, $value);
    }
    if($this->checkOutOfRange($index)) {
      // 检测是否越界
      $code = 2;
      return array($code, $value);
    }
    return array(0, $this->data[$index]);
  }

  public function printData(){
    $format = "";
    for($i=0;$i<$this->length;$i++) {
      $format .= "|".$this->data[$i];
    }
    print($format."\n");
  }
}

// 测试
$array = new MyArray(5);
$array->insert(0,1);
$array->insert(1,2);
$array->insert(2,13);
$array->insert(3,20);
$array->insert(4,30);
var_dump($array->find(8));

// 打印数组
$array->printData();
