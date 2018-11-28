<?php

/**
 * 组合模式
 *
 * 特点：用抽象类规范统一的对外接口
 *      组合对象必须包含添加和删除节点对象。如：add()，remove()等
 *      组合模式通过和装饰模式有着类似的结构图，但是组合模式旨在构造类，而装饰模式重在不生成子类即可给对象添加职责。
 *      装饰模式重在修饰，而组合模式重在表示。
 */

/**
 * 例子：文件和目录计算文件大小
 */

/**
 * 1:定义接口
 * 
 * 规范独立对象和组合对象必须实现的方法，保证它们提供给客户端统一的访问方式
 * __construct构建函数用于传入文件或目录名称，并非必须
 * 这个接口中规范的方法要根据需求来定义，并且同时要考虑独立对象拥有的功能。
 * 如果独立对象之间有差异的功能，不适合聚合在一起，则不能放在组合类中。
 */
abstract class Filesystem{
  protected $name;

  public function __construct($name){
    $this->name = $name;
  }

  public abstract function getName();

  public abstract function getSize();
}

/**
 * 2:生成相关类
 * 2-1:生成目录类
 *   目录类是对象的集合，通过add()和remove()方法管理问价对象和其他目录对象
 */

/**
 * 目录类
 */
class Dir extends Filesystem{
  private $filesystems = [];

  //组合对象必须实现添加方法。因为传入参数规定为Filesystem类型
  //目录和文件都可以添加
  public function add(Filesystem $filesystem){
    $key = array_search($filesystem, $this->filesystems);
    if($key === false){
      $this->filesystems[] = $filesystem;
    }
  }

  //组合对象必须实现移除方法
  public function remove(Filesystem $filesystem){
    $key = array_search($filesystem, $this->filesystems);
    if($key === false){
      unset($this->filesystems[$filesystem]);
    }
  }

  public function getName(){
    return '目录：'.$this->name;
  }

  public function getSize(){
    $size = 0;
    foreach ($this->filesystems as $filesystem) {
       $size += $filesystem->getSize();
    } 
    return $size;
  }
}

/**
 * 2-2:生成文件类
 *   文件类实现具体的功能，但是没有实现add()和remove()方法
 */

/**
 * 对立对象：文本文件类
 */
class TextFile extends Filesystem{
  public function getName(){
    return '文本文件：'.$this->name;
  }

  public function getSize(){
    return 10;
  }
}

/**
 * 独立对象：图片文件类
 */
class ImgFile extends Filesystem{
  public function getName(){
    return '图片：'.$this->name;
  }

  public function getSize(){
    return 100;
  }
}

/**
 * 对立对象：视频文件类
 */
class VideoFile extends Filesystem{
  public function getName(){
    return '视频：'.$this->name;
  }

  public function getSize(){
    return 200;
  }
}

/**
 * 3:客户端调用
 */

// 创建home目录，并加入三个文件
$dir = new Dir('home');
$dir->add(new TextFile('text1.txt'));
$dir->add(new ImgFile('bg1.png'));
$dir->add(new VideoFile('film1.mp4'));

// 在home下创建子目录source
$subDir = new Dir('source');
$dir->add($subDir);

// 创建text2.txt，并放到子目录source中
$text2 = new TextFile('text2.txt');
$subDir->add($text2);

// 打印信息
echo $text2->getName(), '-->', $text2->getSize();
echo '<br />';
echo $subDir->getName(), ' --> ',$subDir->getSize();
echo '<br />';
echo $dir->getName(), ' --> ', $dir->getSize();

/**
 * 输出结果：
 * 文本文件：text2.txt-->10
 * 目录：source --> 10
 * 目录：home --> 320
 */

