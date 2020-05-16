<?php
ini_set("display_errors", "1");

/**
 * 単にnewするだけでなく
 * プロパティに依存オブジェクトを設定して
 * 初めて利用可能になるようなオブジェクトにおける
 * プロパティ設定の一貫性を保つために使う
 * 
 */


/**
 * 実ファクトリを用いて
 * 一貫性のあるプロパティを設定することを目的としたパターン
 * 依存性注入によってお株を奪われつつあるらしい
 *
 */


/**
 *  アブストファクトファクトリ
 * 「作る」
 * 何を作るのかは子供による
 * 
 */
interface FashionFactory
{
  public function createTops();
  public function createBottoms();
  public function createCap();
}


/**
 * ファクトリを使ってプロパティを設定される対象
 * 服
 */
class Fashion
{
  private $tops = null;
  private $bottoms = null;
  private $cap = null;

  public function setTops($tops)
  {
    $this->tops = $tops;
  }
  public function setBottoms($bottoms)
  {
    $this->bottoms = $bottoms;
  }

  public function setCap($cap)
  {
    $this->cap = $cap;
  }



  public function getTops()
  {
    return $this->tops;
  }

  public function getBottoms()
  {
    return $this->bottoms;
  }

  public function getCap()
  {
    return $this->cap;
  }
}

/**
 * 実ファクトリその１
 * 和服工場
 */


class JapaneseFashionFactory implements FashionFactory
{
  private static $instance = null;
  public function __construct()
  {
  }

  // singleton?
  public static function getInstance()
  {
    if (self::$instance == null) {
      // 自分をメンバに持つ
      self::$instance = new JapaneseFashionFactory();
    }
    return self::$instance;
  }

  public function createTops()
  {
    return "長着";
  }
  public function createBottoms()
  {
    return "袴";
  }
  public function createCap()
  {
    return "三度笠";
  }
}

/**
 * 実ファクトリ2
 * 洋服工場
 */




class ForeignFashionFactory  implements FashionFactory
{
  private static $instance = null;
  public function __construct()
  {
  }

  public static function getInstance()
  {
    if (self::$instance == null) {
      // 自分をメンバに持つ
      self::$instance = new ForeignFashionFactory();
    }
    return self::$instance;
  }

  public function createTops()
  {
    return "ジャケット";
  }
  public function createBottoms()
  {
    return "ジーンズ";
  }

  public function createCap()
  {
    return "キャップ";
  }
}


// 和服工場
$jpFactory = JapaneseFashionFactory::getInstance();

// 洋服
$foreignFactory = ForeignFashionFactory::getInstance();




// どちらが作ろうがcreate****という呼び出しになっているのがミソ
// 服に和服工場のトップスとボトムズを設定
$jpFashion = new Fashion();
$jpFashion->setTops($jpFactory->createTops());
$jpFashion->setBottoms($jpFactory->createBottoms());
$jpFashion->setCap($jpFactory->createCap());

$foreignFashion = new Fashion();
$foreignFashion->setTops($foreignFactory->createTops());
$foreignFashion->setBottoms($foreignFactory->createBottoms());
$foreignFashion->setCap($foreignFactory->createCap());

var_dump($jpFashion);
var_dump($foreignFashion);
