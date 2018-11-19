<?php

/**
 * 抽象工厂模式（Abstract Factory Pattern）
 * 提供一个接口，用于创建 相关的对象家族 。
 */

/**
 * 1:定义形状接口
 */
interface Shape{
  public function draw();
}

/**
 * 2:创建实现形状接口的实体类
 */
class Rectangle implements Shape{
  public function draw(){
    echo '我的形状是 长方形';
  }
}

class Square implements Shape{
  public function draw(){
    echo '我的形状是 正方形';
  }
}

/**
 * 3:定义颜色接口
 */
interface Color{
  public function fill();
}

/**
 * 4:创建实现颜色接口的实体类
 */
class Red implements Color{
  public function fill(){
    echo '我的颜色是 红色';
  }
}

class Green implements Color{
  public function fill(){
    echo '我的颜色是 绿色';
  }
}

/**
 * 5:为Color和Shape对象创建抽象类来获取工厂
 */

abstract class AbstractFactory{
  abstract protected function getColor($color);
  abstract protected function getShape($shape);
}

/**
 * 6:创建扩展了 AbstractFactory 的工厂类，基于给定的信息生成实体类的对象。
 */
class ShapeFactory extends AbstractFactory{
  public function getShape($shape){
    $shape = ucfirst($shape);
    return new $shape;
  }

  public function getColor($color){
    return null;
  }
}

class ColorFactory extends AbstractFactory{
  public function getShape($shape){
    return null;
  }

  public function getColor($color){
    $color = ucfirst($color);
    return new $color;
  }
}

/**
 * 工厂管理器
 */

class FactoryProducer{
  public function getFactory($factory){
    $factory = ucfirst($factory).'Factory';
    if($factory && class_exists($factory)){
      return new $factory;
    }else{
      return null;
    }
  }
}

$producer = new FactoryProducer;
$shape = $producer->getFactory('shape');
$rectangle = $shape->getShape('rectangle');
$rectangle->draw();

