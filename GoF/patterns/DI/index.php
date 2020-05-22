<?php

/**
 * Dependency Injection
 * 依存性注入
 * 特定のオブジェクトが依存するオブジェクトは
 * 外部で生成してコンストラクタから渡すようにする
 * 単体テストしてたら普通に出くわす
 */


/**
 * まずはDIじゃないパターンから
 */


class NotDISample
{
  private $dependency = null;
  public function __construct()
  {
    // コンストラクタで依存するオブジェクトをnewする
    // 使うときぬるぽしない
    // これだとDependencyImplしかnewできない
    $this->dependency = new DependencyImpl();
  }

  public function getDependency()
  {
    return $this->dependency;
  }
}

/**
 * DIパターン
 */

class DISample
{
  private $dependency = null;
  public function __construct(Dependency $obj)
  {
    // コンストラクタ渡しのDIパターン
    // 他にセッターで渡しても構わない
    // 依存するオブジェクトを必ず外部注入する
    //new するのが外部になるので依存対象が
    // インタフェースレベルになるから疎結合を実現できる
    $this->dependency = $obj;
  }

  public function getDependency()
  {
    return $this->dependency;
  }
}

interface Dependency
{
  public function getName();
}

class DependencyImpl implements Dependency
{
  public function getName()
  {
    return __CLASS__;
  }
}


class AnotherDependencyImpl  implements Dependency
{
  public function getName()
  {
    return __CLASS__;
  }
}

$obj = new NotDISample();
$di = new DISample(new DependencyImpl());
$anotherDI = new DISample(new AnotherDependencyImpl);

print $obj->getDependency()->getName() . "<br>";

print $di->getDependency()->getName() . "<br>";

print $anotherDI->getDependency()->getName() . "<br>";
