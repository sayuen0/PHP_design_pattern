
<?php
/**
 *
 * 支持者と作業者を分割統治して柔軟な組み合わせを実現
 *  多少の効率をロスしてでも全ての手続きを一貫した手順にまとめる
 * 
 *
 *  「異なる事柄を任せる人材」を選出
 * 「小さな命令の手続きを統一」
 * 「小さなことを任せる人材もち、自分はそれに強く気にかけない」
 */


/**
 * Abstraction: inplementorを保持しImplementorを使った
 * 基本的な機能が実装
 * RefinedAbstraction: Abstractionの機能追加
 * Implementor : Abstractionが使用するインタフェースを規定
 * ConcreteImplementor : 具体的なImplementor
 */



//  Abstraction

class Bridge
{
  private $impl;

  public function __construct($impl)
  {
    if (!($impl instanceof Implement)) {
      throw new Exception("それは無理な相談");
    }
    $this->impl = $impl;
  }
  /**
   * implementorのdoMethodを使う
   * implementorのdoMethodを切り替えるだけで実装が切りか実装が切り替わる
   * 
   *
   * @return void
   */
  public function doMethod()
  {
    return $this->impl->doMethod();
  }
}


// RefindedAbstraction その1

class BridgeSub1 extends Bridge
{
  public function doMethod()
  {
    return "Sub1 | " . parent::doMethod();
  }
}


// RefinedAbstraction その2

class BridgeSub2 extends Bridge
{
  public function doMethod()
  {
    // 言い換えれば
    // 自分の処理＋親からの伝言が実装できる
    // 親が何をdoMethodするのかはImplementによる
    return "Sub2 | " . parent::doMethod();
  }
}



// implementor

interface Implement
{
  public function doMethod();
}


// concrete implementor

class ImplementSample1  implements Implement
{
  public function doMethod()
  {
    return "実装1 ";
  }
}

class ImplementSample2  implements Implement
{
  public function doMethod()
  {
    return "実装2 ";
  }
}



function say($i)
{
  print "$i <br>";
}


// 以下同じdoMethodを使っているが
// RefinedAbstractionで機能が拡張され
// concreteImplementを差し替えることにより
// 別の実装処理がされる

$parent = new Bridge(new ImplementSample2());
say($parent->doMethod());

$subclass1 = new BridgeSub1(new ImplementSample1);
say($subclass1->doMethod());

$subclass1_2 = new BridgeSub1(new ImplementSample2);
say($subclass1_2->doMethod());

$subclass2 = new BridgeSub2(new ImplementSample1);
say($subclass2->doMethod());

$subclass2_2 = new BridgeSub2(new ImplementSample2);
say($subclass2_2->doMethod());
