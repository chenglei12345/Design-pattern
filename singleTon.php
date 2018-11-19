<?php 

/**
 * 单例模式
 * 特点：4私 1公 
 * 一个私有静态属性，构造方法私有，克隆方法私有，重建方法私有，一个公共静态方法
 */

/**
 * 最基础的单例模式
 */
class SingleTon{
  // 声明$instance 为私有静态类型，用于保存当前类实例化后的对象
  private static $instance = null;

  // 构造方法声明为私有方法，禁止外部程序使用new实例化，只能在内部new
  private function __construct(){}

  // 声明成私有方法，禁止克隆对象
  private function __clone(){}

  // 声明成私有方法，禁止重建对象
  private function __wakeup(){}

  // 外部获取当前对象的唯一方式
  public static function getInstance(){
    if(self::$instance == null){
      self::$instance = new self();
    }
    return self::$instance;
  }
}

/**
 * 测试用例
 */
class test{
  private static $instance = null;

  private static $config = null;

  private function __construct($config = []){
    self::$config = $config;
    echo '我被实例化了';
  }

  public static function getInstance($config = []){
    if(self::$instance == null){
      self::$instance = new self($config);
    }
    return self::$instance;
  } 

  public function getConfig(){
    var_dump(self::$config);
  }

  private function __clone(){}

  private function __wakeup(){}
}

// 只第一次进行实例化
$test1 = test::getInstance([1]);
$test1->getConfig();

// 直接读私有静态变量 array('0'=>1)
$test2 = test::getInstance([2]);
$test2->getConfig();




