<?php

/**
 * 适配器模式
 * 
 * 意图：将一个类的接口转换成客户希望的另外一个接口。适配器模式使得原本由于接口不兼容而不能一起工作的那些类可以一起工作。
 * 特点：对外暴露的使用方法相同（便于客户端调用，避免后期接口修改，大范围改动），但是类的内部对于方法的实现不一致。
 * 注意：
 *   适配器模式中，适配器类的名称和创建方式一定是不会频繁发动的
 *   对于客户端来说，引用适配器类的方式应该是统一而不变的
 * 
 */

/**
 * 例子：支付集成
 */

/**
 * 支付宝支付类
 */
class Alipay{
  public function sendPayment(){
    echo '使用支付宝支付';
  }
}

/**
 * 微信支付类
 */
class WechatPay{
  public function scan(){
    echo '微信扫码支付';
  }
}

/**
 * 适配器接口，所有的支付适配器都要实现这个接口
 * 不管第三方支付实现方式如何，对于客户端都用pay()方法完成支付
 */

interface PayAdapter{
  public function pay();
}

/**
 * 支付宝适配器
 */
class AlipayAdapter implements PayAdapter{
  public function pay(){
    // 实例化Alipay类，并用Alipay的方法实现支付
    $alipay = new Alipay();
    $alipay->sendPayment();
  }
}

/**
 * 微信适配器
 */
class WechatPayAdapter implements PayAdapter{
  public function pay(){
    // 实例化WechatPay类，并用WechatPay的方法实现支付
    $wechatPay = new WechatPay();
    $wechatPay->scan();
  }
}

/**
 * 客户端使用
 */
$alipay = new AlipayAdapter();
// 统一用pay方式支付
// 如果Alipay的支付方式变了，只需要修改AlipayAdapter中的pay()即可
$alipay->pay();

$wechatPay = new WechatPayAdapter();
$wechatPay->pay();
