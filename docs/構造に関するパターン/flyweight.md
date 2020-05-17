# Flyweightパターン

> **同じものを共有して無駄をなくす**
>
## 概要

- 等価なオブジェクトは共有したら軽量化できるよねって話


## 登場人物

- ファクトリ: 生成するやつ
- フライウェイト: 軽くしたいやつ

## やり方

1. ファクトリはフライウェイトオブジェクトをメンバーに持つ
2. ファクトリ自身はpublicでstaticな、1度目の呼び出しだけ「生成」し2度目以降の呼び出しはすでに生成したやつを返すgetInstanceメソッドを持つ
3. ファクトリからのフライウェイトは、既にあれば既存のものを返し、なかったら一度だけ生成して登録して返す


## クラス図

![](https://upload.wikimedia.org/wikipedia/commons/b/be/Flyweight_UML_class_diagram.svg)

## メリット

- メモリ節約：これに尽きる
- 時間節約：インスタンス生成に時間のかかるオブジェクトなら

## 注意点

### intrinsic(本来備わっている情報)かextrinsic(外からやってきた情報)か


Flyweightに変更を加えると当然だけどアプリケーション内のFlyweightインスタンス全てに変更が共有される。

- イントリンジック: 場所や状況に依存しない情報。共有して良いのでFlyweightに組み込んで良い
- エクストリンジック: 場所や状況に応じ変わる情報。共有されるとおかしいので、組み込んではいけない


# ソース

```php
<?php


/**
 * キャッシュを作ってインスタンス生成の負荷を減らす
 * 要するにゆるいシングルトン
 * むしろこいつのきつい版がシングルトン
 * もしシングルトンを検討するときは、
 * まず先にこいつを検討して
 */

/**
 * シングルトンは自分が唯一複製されない
 * フライウェイトは他のクラスを複製しない
 * シングルトン的なやつに引数を渡して状況に応じて
 * キャッシュからインスタンスを返したり
 * キャッシュしながらインスタンスを返したりする
 */


/**
 * 腹心
 */

class Confidant
{
  private $name;

  public function __construct($key)
  {
    $this->name = $key;
  }
}


/**
 * 腹心を雇い、
 * 一度作ったものは共有されるファクトリー
 * シングルトンで実装
 */


class ConfidantFactory
{
  private $confidant = array();
  private static $instance = null;

/**
*private なコンストラクタ
*/
  private function __construct()
  {
  }

/**
* 唯一のインスタンス取得メソッド
*/
  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance = new ConfidantFactory();
    }
    return self::$instance;
  }

  /**
   * 初めて雇うものは
   * 生成され、すでに雇っているものは作ったものが共有される
   */

  public function get($key)
  {
    if (!$this->confidant[$key]) {
      $this->confidant[$key] = new Confidant($key);
      print "[$key]を新たに雇うのです。<br>";
    } else {
      print "すでにいるので使いまわしましょう。<br>";
    }
    return $this->confidant[$key];
  }
}

$factory = ConfidantFactory::getInstance();
if ($factory->get("執事") === $factory->getInstance()->get("執事")) {
  print  "同じオブジェクトなのです";
  # code...
} else {
  print "別オブジェクトです";
}

```
