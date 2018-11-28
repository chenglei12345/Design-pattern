<?php

/**
 * 代理模式
 * 意图：
 *   为其他对象提供一种代理以控制对这个对象的访问。
 * 主要解决：
 *   直接访问对象时带来的问题：要访问的对象在远程的机器上。在面向对象系统中，有些对象由于某些原因（比如对象创建开销很大，或者某些操作需要安全控制，或者需要进程外的访问），直接访问会给使用者或者系统结构带来很多麻烦，我们可以在访问此对象时加上一个对此对象的访问层。
 * 何时使用：
 *   想在访问一个类时做一些控制。
 * 如何解决：
 *   增加中间层。
 * 关键代码：
 *   实现与被代理类组合。
 * 应用实例：
 *   Windows 里面的快捷方式
 *   买火车票不一定在火车站买，也可以去代售点
 * 优点：
 *   职责清晰
 *   高扩展性
 *   智能化
 * 缺点：
 *   由于在客户端和真实主题之间增加了代理对象，因此有些类型的代理模式可能会造成请求的处理速度变慢。
 *   实现代理模式需要额外的工作，有些代理模式的实现非常复杂。
 * 使用场景：
 *   远程代理
 *   虚拟代理
 *   Copy-on-Write 代理
 *   保护（Protect or Access）代理
 *   Cache代理
 *   防火墙（Firewall）代理
 *   同步化（Synchronization）代理
 *   智能引用（Smart Reference）代理
 * 注意事项：
 *   和适配器模式的区别：适配器模式主要改变所考虑对象的接口，而代理模式不能改变所代理类的接口
 *   和装饰器模式的区别：装饰器模式为了增强功能，而代理模式是为了加以控制
 * 
 */

/**
 * 我们将创建一个 Image 接口和实现了 Image 接口的实体类。
 * ProxyImage 是一个代理类，减少 RealImage 对象加载的内存占用。
 * ProxyPatternDemo，我们的演示类使用 ProxyImage 来获取要加载的 Image 对象，并按照需求进行显示。
 */

/**
 * 1:创建一个接口
 */
interface Image{
  public function display();
}

/**
 * 2:创建实现接口的实体类
 *   真实类
 */
class Realimage implements Image{
  private $fileName;

  public function __construct($fileName = null){
    $this->fileName = $fileName;
    $this->loadFromDisk($this->fileName);
  }

  private function loadFromDisk(){
    echo 'Loading:'.$this->fileName;
  }

  public function display(){
    echo 'Displaying:'.$this->fileName;
  }
}

/**
 * 代理类
 */
class ProxyImage implements Image{
  private $fileName;
  private $realImage;

  public function __construct($fileName = null){
    $this->fileName = $fileName;
  }

  public function display(){
    if(is_null($this->realImage)){
      $this->realImage = new Realimage($this->fileName);
    }
    $this->realImage->display();
  }
}

/**
 * 客户端请求
 */

$img = new ProxyImage('test1.jpg');
// 第一次display 在代理类中 实例化 Realimage，结果会有 Loading:test1.jpg
$img->display();
echo PHP_EOL;
// 第二次display 在代理类中 直接调用真实类的display方法，结果没有 Loading:test1.jpg
$img->display();
echo PHP_EOL;
// 打印这个对象 可以看到类中的realImage 已被实例化
var_dump($img);