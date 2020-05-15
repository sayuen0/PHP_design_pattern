
# Decoratorパターン

## 概要

いわゆるラッパークラス

本質部分をプロパティに持って、委譲すれば良し

## 他のパターンとの関連

### Adapter

目的が違う

- Adapterは「右と左の端子の形式が違うから、それらを接続するインタフェースが必要」という意図
- Decoratorは「左右の端子があっているところに、それと同じ形の端子を付けた装置をを割り込ませる」


# ソース

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
