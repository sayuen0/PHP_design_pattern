
# Decoratorパターン

> **飾り枠と中身の同一視**

## 概要

いわゆるラッパークラス

本質部分をプロパティに持って、委譲すれば良し


## 登場人物

- Component: 機能追加のコアとしてのインタフェース。デコレーション前のスポンジケーキ
- ConcreteComponent: 具体的なスポンジケーキ
- Decorator: 自分が飾っている対象(Component)をプロパティに持ち、かつComponentを実装している
- ConcreteDecorator: Decoratorを実装

## クラス図

![480px\-Decorator\_UML\_class\_diagram\.svg\.png \(480×380\)](https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Decorator_UML_class_diagram.svg/480px-Decorator_UML_class_diagram.svg.png)


## やり方

- DecoratorはComponentを実装し、さらにComponentをプロパティとしてもつ
  - こうすることでConcreteDecoratorはConcreteComponentの機能を全て使うことができるようになる


## メリット

- 中身を変えずに機能追加ができる
  - DecoratorもComponentも同一インタフェースを持つが、包めば包むほど機能が追加される
  - **その際包まれるComponentの修正は必要なし**
- 単純な品揃えでも多様な機能追加ができる
  - アイスクリームのトッピングを、バニラ、チョコ、ストロベリー、キウイ、組み合わせとして

## 関連

### Adapter

目的が違う

- Adapterは「右と左の端子の形式が違うから、それらを接続するインタフェースが必要」という意図
- Decoratorは「左右の端子があっているところに、それと同じ形の端子を付けた装置をを割り込ませる」
  - 「右も左もUSBだけど、平文じゃなく暗号化できるコードをかましますよ」

## Javaソースに見る

Java.ioパッケージクラスはDecoratorパターンを採用している

これにより極めて多様な機能追加が実現できる

```java
//普通にファイルを読み込む
Reader reader = new FileReader(filename);
//バッファリングして読み込む
Reader reader = new BufferReader(new FileReader(filename));
//行番号を指定し、バッファリングして読み込む
Reader reader = new LineNumberReader(new BufferReader(new FileReader(filename)));
//行番号は管理するけど、バッファリングしない
Reader reader = new LineNumberReader(new FileReader(filename));
//行番号を管理しバッファリングするが、ファイルからでなくネットワークから読み込む
java.net.Socket socket = new Socket(hostname,portNumber);
Reader reader = new LineNumberReader(new BufferReader(new InputStreamReader(socket.getInputStream())));
```

## ソース

### PHP

```php
<?php

/**
 * オブジェクトの重ね着で機能の組み合わせを無限大に
 * 「委譲による継承」
 */


/**
 * 単に継承するだけではなく
 * 継承元クラスのインスタンスを内包して
 * 単にsuperを呼ぶのではなく
 * 組み合わせを自由に変えることができる
 */


/**
 * 拡張対象クラス
 */


class Inner
{
  public function __construct()
  {
  }
  public function getName()
  {
    return __CLASS__;
  }
}

/**
 * 一番内側のクラスを拡張
 */


class Outer extends Inner
{
  private $inner = null;

  public function __construct(Inner $inner)
  {
    $this->inner = $inner;
  }

  public function getName()
  {
    $name = $this->inner->getName();
    return $name . " in Outer";
  }
}

/**
 * さらに拡張
 */


class OuterOfOuter extends Outer
{
  private $inner;

  public function __construct($inner)
  {
    $this->inner = $inner;
  }


  public function getName()
  {
    $name = $this->inner->getName();
    return $name . " in OuterOfOuter";
  }
}


/**
 * さらにさらに拡張
 */


class SuperOuterOfOuter extends OuterOfOuter
{
  private $inner;

  public function __construct($inner)
  {
    $this->inner = $inner;
  }

  public function getName()
  {
    $name = $this->inner->getName();
    return $name . " in SuperOuterOfOuter";
  }
}


$obj = new OuterOfOuter(new Outer(new Inner()));
print $obj->getName();
print "<br>";

$obj = new SuperOuterOfOuter(new Outer(new Inner()));
print $obj->getName();
print "<br>";

$obj = new Outer(new SuperOuterOfOuter(new Outer(new SuperOuterOfOuter(new Inner()))));
print $obj->getName();
print "<br>";
```
