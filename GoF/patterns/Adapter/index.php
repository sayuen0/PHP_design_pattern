<?php

/**
 * ;継承によるAdapter
 */


/**
 * パイ皿
 * MakePieを使いたいけれども、
 * インタフェースが思惑とずれる
 * cookPieというインタフェースでパイを作成したい
 */
class PieDish
{
  public function MakePie()
  {
    print "パイを作る";
  }
}


// cookPieメソッドを持つアダプター
interface Adapter
{
  public function cookPie();
}



/**
 * アダプタを適用させた新しいパイ皿
 */


class PieDishWithAdapter  extends PieDish implements Adapter
{


  /**PieDishクラスのmakePieを呼ぶ */
  public function cookPie()
  {
    $this->makePie();
  }
}


$pieDish = new PieDishWithAdapter();
$pieDish->cookPie();





/**
 * 委譲によるアダプター
 */


class PieDish2
{
  public function makePie()
  {
    print "パイを作る";
  }
}

/**
 * インタフェースでなくabstract class
 */


abstract class Adapter2
{
  public abstract function cookPie();
}


/**
 * 先ほどの継承パターンと同様に
 * 元のクラスを変更せずインタフェースをcookPieに適合させる
 */

class PieDishWithAdapter2 extends Adapter2
{
  private $target;

  public function __construct($target)
  {
    $this->target = $target;
  }

  public function cookPie()
  {
    $this->target->makePie();
  }
}

$pieDish2 = new PieDishWithAdapter2(new PieDish2());
$pieDish2->cookPie();




// これまでのサンプルでもいいのだが、
// adapterパターンの真骨頂はここから
// オーブンはAdapterインタフェースしか受け付けない
// 元のクラスのままだと焼けないところを
// 元のクラスに何も手を入れずオーブンで焼けるようになった


class Oven
{
  public static function bake(Adapter $adapter)
  {
    $adapter->cookPie();
  }
}


class Oven2
{
  public static function bake(Adapter2 $adapter2)
  {
    $adapter2->cookPie();
  }
}


Oven::bake(new PieDishWithAdapter());
Oven2::bake(new PieDishWithAdapter2(new PieDish2()));


