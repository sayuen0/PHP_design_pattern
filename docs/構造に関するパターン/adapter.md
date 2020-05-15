# Adapter

「右と左の端子があっていなくて繋げないから、両端子を繋げられるオブジェクトを間に挟む」

## 目的

「本来の機能への委譲」

## 登場人物

- インタフェース: ユーザーがそういう名前で呼び出したいメソッドを持つ
  - fireとかcreateとか単純な名前
- Adapter: 挟む主体。インタフェースを実装する
- Adaptee: 挟まれて対応される主体

## やり方

2つある

### 1. インタフェースによる実装

1. クライアントから呼び出したい名前のシグネチャをインタフェースに置く
2. それを実装し、かつAdapteeを継承したAdapterクラスを作成する
3. Adapter内でインタフェースのメソッドをOverrideして、Adapteeのメソッドを呼び出す


### 2. 委譲による実装

1. クライアントから呼び出したい名前のシグネチャをインタフェースに置く
2. それを継承したAdapterクラスを作成し、プロパティにAdapteeを持たせる
3. スーパークラスのメソッドをオーバーライドして、自分が持つAdapteeのメソッドを呼び出す


## メリット(用途)

**既存クラスを改造する必要がなくなる**。本来クラスは書き換えたらテストしなけばいけない。

テストの通った既存クラスをラップすることで追加機能分だけをテストすれば良くなる

**既存クラスのソース内容は知る必要はない**。仕様がわかればAdapterで新しいクラスを作成できる。


## 他との関連

### [Decorator](/docs/decorator.md)

元のオブジェクトをラップするという点で同一。

ただしDecoratorの目的は「本来の機能の拡張」。意味合いは「右と左の端子があっているところに、同じく端子のあう機能を追加した中間装置をかます」


# ソース

## PHP

```php
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

```
