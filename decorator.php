<?php

/**
 * 装饰器模式
 *
 * 概念：
 *   装饰器模式，又名包装(Wrapper)模式，该模式向一个已有的对象添加新的功能，而不改变其结构。
 * 意图：
 *   动态地给一个对象添加一些额外的职责。就增加功能来说，装饰器模式相比生成子类更为灵活。
 * 主要解决：
 *   一般的，我们为了扩展一个类经常使用继承方式实现，由于继承为类引入静态特征，并且随着扩展功能的增多，子类会很膨胀。
 * 何时使用：
 *   在不想增加很多子类的情况下扩展类。
 * 如何解决：
 *   将具体功能职责划分，同时继承装饰者模式。
 * 关键代码：
 *   Component 类充当抽象角色，不应该具体实现
 *   修饰类引用和继承 Component 类，具体扩展类重写父类方法。
 * 应用实例：
 *   孙悟空有 72 变，当他变成"庙宇"后，他的根本还是一只猴子，但是他又有了庙宇的功能。
 * 比较：
 *   通常给对象添加功能有3中方法：
 *     直接修改类，添加相应的功能
 *     派生对应的子类扩展新功能
 *     使用对象组合的方式
 *   直接修改类代码是一种侵入式修改，很容易对类功能造成损害。
 *   使用继承方式扩展功能，则在整个子类中添加功能，即使有的对象不需要，new出来也会有这些新功能。
 * 优点：
 *   装饰器模式是典型的基于对象组合的方式，可以很灵活的给对象添加所需要的功能
 *   它能动态的为一个对象增加功能，而且还能动态撤销。
 *   继承不能做到这一点，继承的功能是静态的，不能动态增删。
 * 缺点：
 *   多层装饰比较复杂。
 * 使用场景：
 *   扩展一个类的功能
 *   动态增加功能，动态撤销
 * 注意事项：
 *   可代替继承
 */

/**
 * 例子：邮件发送
 */

/**
 * 1:定义邮件内容接口，规范实现类
 */
interface EmailBody{
  public function body();
}

/**
 * 2:正常邮件内容类
 */
class MainEmail implements EmailBody{
  public function body(){
    echo '公司准备为您加薪50%。';
  }
}

/**
 * 3:主装饰器类，这个类用属性保存MainEmail类的对象，然后根据需要改变它的行为
 */
abstract class EmailBodyDecorator implements EmailBody{
  // 保存MainEmail类对象
  protected $emailBody;

  // 实例化这个类或者子类时，必须传入一个被修饰的对象
  public function __construct(EmailBody $emailBody)
  {
    $this->emailBody = $emailBody;
  }

  // 用抽象方法声明EmailBody规定的方法，
  // 在子类中用来改变MainEmail对象的行为
  abstract public function body();
}

/**
 * 4:装饰器子类（不同功能的类）
 */
class NewYearEmail extends EmailBodyDecorator{
  public function body(){
    echo '元旦快乐！';
    $this->emailBody->body();
  }
}

class SpringFestivalEmail extends EmailBodyDecorator{
  public function body(){
    echo '春节快乐！';
    $this->emailBody->body();
  }
}

/**
 * 5:客户端调用
 */

/**
 * 5-1:正常发送邮件
 * 输出：公司准备为您加薪50%。
 */
$email = new MainEmail;
$email->body();

/**
 * 5-2:发送有元旦快乐的祝福邮件
 * 输出：元旦快乐！公司准备为您加薪50%。
 */
$emailNewYear = new NewYearEmail($email);
$emailNewYear->body();

/**
 * 5-3:发送有春节快乐的祝福邮件
 * 输出：春节快乐！公司准备为您加薪50%。
 */
$emailSpring = new SpringFestivalEmail($email);
$emailSpring->body();

/**
 * 5-4:发送同时有【元旦】和【春节】祝福的邮件
 * 输出：春节快乐！元旦快乐！公司准备为您加薪50%。
 */
$emailTwo = new SpringFestivalEmail($emailNewYear);
$emailTwo->body();
