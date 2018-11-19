<?php

/**
 * 工厂方法模式
 * 定义一个创建对象的接口，让子类决定哪个类实例化
 * 可以解决简单工厂模式中的封闭开放原则问题
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
class Plane implements Vehicle{
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

/**
 * 这里是与简单工厂的本质区别所在，将对象的创建抽象成一个接口
 */
interface createVehicle{
  public function create();
}

class FactoryPlane implements createVehicle{
  public function create(){
    return new Plane;
  }
}

class FactoryBoat implements createVehicle{
  public function create(){
    return new Boat;
  }
}

/**
 * 工厂方法
 */

class Client{
  public function test(){
    $factoryPlane = new FactoryPlane;
    $plane = $factoryPlane->create();
    $plane->drive();

    $factoryBoat = new FactoryBoat;
    $boat = $factoryBoat->create();
    $boat->drive();
  }
}

$f = new Client;
$f->test();