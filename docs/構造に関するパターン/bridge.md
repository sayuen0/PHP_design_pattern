
# bridgeパターン

> **機能の階層と実装の改装を分ける**

## 概要
継承よりコンポジションがいいよねっていうパターン


extendsによる複数概念と
implementsによる複数概念の掛け算的橋渡し


## メリット(用途)

継承には2種類の意味がある

- **機能のクラス階層**: サブクラスに新しい機能を拡張追加する
- **実装のクラス階層**: サブクラスに抽象メソッドの内容をオーバーライドする

継承は1段階ずつ行う都合、サブクラスを作ったとしてもそれがどちらの意味の文脈なのか判別しにくい。
そのサブクラスには機能を追加して抽象メソッドを実装して、をどっちもしないといけないのか

継承におけるこれら2種類の**意味を分離**するのが目的


- 機能の追加は、機能のクラス階層に行えば良い
  - **実装のクラス階層は修正する必要なし**
  - **今追加した機能は全ての実装で利用できる**


## 登場人物

- 抽象化(Abstraction): 「機能のクラス階層」の最上位クラス
- 改善した抽象化(RefinedAbstraction): 抽象化のサブクラス。新しい機能の追加
- 実装者(Implementor): 「実装のクラス階層」の最上位クラス。抽象メソッドしか持たない
- 具体的な実装者(ConcreteImplementor): 実装者を実装する

## クラス図

![Bridge Pattern](https://upload.wikimedia.org/wikipedia/commons/c/cf/Bridge_UML_class_diagram.svg)

## やり方

- 抽象化に実装者をプロパティで持たせる(**委譲**)
- 新しい機能を追加したかったら、改善した抽象化に持たせる
- 新しい実装を作成したかったら、具体的な実装者を新たに持たせる

## ユースケース

### ファイル形式と取引形式

> たとえば、仕入れ先リストや顧客リストといった、取引先リストの派生モデルに関係するもの (What) と、HTML で表示したいか CSV でダウンロードしたいかといった、出力機能の派生モデルに関係するもの (How) を分ける。で、What が How を持つ形で組み合わさったインスタンスになる感じです。流行りの言葉でいえば、ドメインモデルとインフラストラクチャの組み合わせがユースケースだよって感じかな。



- 仕入先か
- 得意先か

Whatの軸(実装のクラス階層)と

- CSV出力か
- HTML表示か

Howの軸(機能のクラス改装)を混ぜる

2*2=4のマトリクスを生成

### マルチOS

- Windows
- Mac
- Linux

といったOS依存の実装は「実装のクラス階層」に行う
何か機能を実装しても、それは


# ソース

```php

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

```
