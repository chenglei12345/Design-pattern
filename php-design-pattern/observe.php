<?php 

/**
 * 观察者模式
 *
 * 意图：定义对象间的一种一对多的依赖关系，当一个对象的状态发生改变时，所有依赖于它的对象都得到通知并被自动更新。
 * 主要解决：一个对象状态改变给其他对象通知的问题，而且要考虑到易用和低耦合，保证高度的协作。
 * 何时使用：一个对象（目标对象）的状态发生改变，所有的依赖对象（观察者对象）都将得到通知，进行广播通知。
 * 如何解决：使用面向对象技术，可以将这种依赖关系弱化。
 * 关键代码：在抽象类里有一个 ArrayList 存放观察者们。
 * 应用实例：
 *   拍卖的时候，拍卖师观察最高标价，然后通知给其他竞价者竞价。 
 *   实时事件处理系统
 *   组件间解耦
 *   数据库驱动的消息队列系统
 * 优点：
 *   观察者和被观察者是抽象耦合的
 *   建立一套触发机制
 * 缺点：
 *   观察者发生变化通知被观察者需要时间
 *   观察者只知道被观察者发生了变化，但是不知道具体原因
 * 注意事项：
 *   避免循环引用
 *   如果顺序执行，某一观察者错误会导致系统卡壳，一般采用异步方式
 *   
 */

/**
 * 例子：订单下单操作
 */

/**
 * 1:定义被观察者接口
 */
interface Observable{
  // 添加/注册观察者
  public function attach(Observer $observer);

  // 删除观察者
  public function detach(Observer $observer);

  // 触发通知
  public function notify();
}

/**
 * 2:实例化被观察者
 */
class Order implements Observable{
  // 保存观察者(非常重要)
  private $observers = [];

  // 订单状态
  private $state = 0;

  // 添加/注册观察者
  public function attach(Observer $observer){
    $key = array_search($observer, $this->observers);
    if($key === false){
      $this->observers[] = $observer;
    }
  }

  // 除观察者
  public function detach(Observer $observer){
    $key = array_search($observer, $this->observers);
    if($key !== false){
      unset($this->observers[$key]);
    }
  }

  // 遍历调用观察者的update()方法进行通知，不用关心具体实现方式
  public function notify(){
    foreach ($this->observers as $observer) {
      $observer->update($this);
    }
  }

  // 订单状态有变化是发送通知
  public function addOrder(){
    $this->state = 1;
    $this->notify();
  }

  // 获取提供给观察者的状态
  public function getState(){
    return $this->state;
  }
}

/**
 * 3:观察者接口
 */
interface Observer{
  // 接收到通知的处理方法
  public function update(Observable $observable);
}

/**
 * 4:实例化观察者
 * 发送邮件
 */
class Email implements Observer{
  public function update(Observable $observable){
    $state = $observable->getState();
    if($state){
      echo '发送邮件：您已经成功下单';
    }else{
      echo '发送邮件：下单失败，请重试';
    }
  }
}

/**
 * 短信通知
 */
class Message implements Observer{
  public function update(Observable $observable){
    $state = $observable->getState();
    if($state){
      echo '短信通知：您已经成功下单';
    }else{
      echo '短信通知：下单失败，请重试';
    }
  }
}

/**
 * 记录日志
 */
class Log implements Observer{
  public function update(Observable $observable){
    echo '记录日志：生成了一个订单记录';
  }
}

/**
 * 客户端调用
 */

// 创建观察者对象
$email = new Email();
$message = new Message();
$log = new Log();

// 创建订单对象
$order = new Order();

// 向订单兑现各种注册3个观察者：发送邮件，短信通知，记录日志
$order->attach($email);
$order->attach($message);
$order->attach($log);

/**
 * 添加订单，添加时会自动发送通知给观察者
 * 结果：
 *   发送邮件：您已经成功下单短信通知：您已经成功下单记录日志：生成了一个订单记录
 */
$order->addOrder();

echo PHP_EOL;

// 删除记录日志观察者
$order->detach($log);

/**
 * 添加另一个订单，会再次发送通知给观察者
 * 结果：
 *   发送邮件：您已经成功下单短信通知：您已经成功下单
 */
$order->addOrder();