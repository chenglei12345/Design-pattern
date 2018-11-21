<?php

/**
 * 策略模式
 * 意图：
 *   定义一系列的算法，把它们一个个的封装起来，并且使它们可以相互替换
 * 主要解决：
 *   在有多种算法相似的情况下，使用 if...else 所带来的复杂和难以维护
 * 何时使用：
 *   一个系统有许多许多类，而区分它们的只是他们直接的行为
 * 如何解决：
 *   将这些算法封装成一个一个的类，任意的替换
 * 关键代码：
 *   实现同一个接口
 * 优点：
 *   算法可以自由切换
 *   避免使用多重条件判断
 *   扩展性良好
 * 缺点：
 *   策略类会增多
 *   所有策略类都需要对外暴露
 * 注意事项：
 *   如果一个系统的策略类多于4个，就要考虑使用混合模式，解决策略类膨胀的问题
 */

/**
 * 例子：数组输出（序列化输出，JSON字符输出，数组格式输出）
 */


/**
 * 1:定义接口
 */
interface OutputStrategy{
  public function render($array);
}

/**
 * 2:定义策略类
 *   2-1:返回序列化字符串
 */
class SerializeStrategy implements OutputStrategy{
  public function render($array){
    return serialize($array);
  }
}

/**
 * 2-2:返回JSON编码后的字符串
 */
class JsonSteategy implements OutputStrategy{
  public function render($array){
    return json_encode($array);
  }
}

/**
 * 2-3:直接返回数组
 */
class ArraySteategy implements OutputStrategy{
  public function render($array){
    return $array;
  }
}

/**
 * 3:定义环境类，用来管理策略，实现不同策略的切换功能 
 */
class Output{
  private $outputStrategy;

  // 传入的参数必须时策略类接口的子类或子类的实例
  public function __construct(OutputStrategy $outputStrategy){
    $this->outputStrategy = $outputStrategy;
  }

  public function renderOutput($array){
    return $this->outputStrategy->render($array);
  }
}

/**
 * 4:客户端
 */
$test = ['a','b','c'];

// 需要返回数组
$outPut = new Output(new ArraySteategy());
$data = $outPut->renderOutput($test);
var_dump($data);
echo PHP_EOL;

// 需要返回JSON
$outPut = new Output(new JsonSteategy());
$data = $outPut->renderOutput($test);
var_dump($data);

