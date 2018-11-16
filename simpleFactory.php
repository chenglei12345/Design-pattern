<?php

/**
 * 简单工厂模式
 * 意图：定义一个创建对象的接口，让其子类自己决定实例化哪一个工厂类，工厂模式使其创建过程延迟到子类进行。
 * 何时使用：我们明确地计划不同条件下创建不同实例时。
 * 
 */

/**
 * 定义一个交通类的接口
 */
interface Vehicle{
  public function drive();
}

/**
 * 定义继承类
 */
class Plan implements Vehicle{
  public $name = '飞机';
  public function drive(){
    echo $this->name.'在天上飞';
  }
}

class Boat implements Vehicle{
  public $name = '船';
  public function drive(){
    echo $this->name.'在水里游';
  }
}

class Car implements Vehicle{
  public $name = '汽车';
  public function drive(){
    echo $this->name.'在路上跑';
  }
}

/**
 * 定义工厂类,专门用于类的创建
 */
class VehicleFactory{
  public static function build($className = null){
    // 首字母大写
    $className = ucfirst($className);
    if($className && class_exists($className)){
      return new $className();
    }
    return null;
  }
}


/**
 * 客户端调用实例
 */

$car = VehicleFactory::build('car');
$car->drive();

// 不存在的类会报错
$bike = VehicleFactory::build('bike');
$bike->drive();