# Singleton

神：人間からは干渉できないもの

絶対不変であり、どの人間にとっての共通の認識を持つ

その必要条件は

- 2度目以降に呼び出されると1度目と同じ実態を返す
- イミュータブルである

こと。

## やり方

1. コンストラクタをprivateにする
2. **唯一の**public staticなインスタンス生成メソッドを作成し、その中で一度だけ生成したインスタンスを返す

## メリット

クッソ重いインスタンスがアプリケーション内に一つしか生成されないことを約束できるので、メモリ節約になる

同時に複数インスタンスを管理しなくて良くなるので予期せぬバグを防げる

## 関連

これらのパターンはインスタンスが1つであることが多い

- Abstract Factory
- Builder
- Facade
- Prototype



# ソース

```php
<?php


/**
 * 絶対唯一君臨するグローバル変数
 * システム中に一つだけあれば良い、または一つしかいて欲しくない
 * インスタンスを制御するためのパターン
 * 生成が重くて至る所でnewさせちゃいけないとき
 */




/**
 * ログや設定ファイル、重いオブジェクトなど
 * その実態を使いまわしたいときに用いる
 * やり方
 * 
 * 1. コンストラクタをprivateにする
 * 2. 自身を保持するprivate staticな変数を作成する
 * 3. 自身を返す public staticなメソッドを作る
 * 
 * 
 */


class Singleton
{
  private static $instance;

  /**
   * 外部からnewできないようにコンストラクタを
   * privateで実装
   */

  private function __construct()
  {
  }

  /**
   * インスタンスが生成されていなければnew、
   * されていればそのままインスタンスを返す
   */

  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance  = new Singleton();
    }
    return self::$instance;
  }
}


$obj1 = Singleton::getInstance();
$obj2 = Singleton::getInstance();

if ($obj1 === $obj2) {
  print "同じオブジェクトだ";
} else {
  print "違うオブジェクトだ";
}

```
