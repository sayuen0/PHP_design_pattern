# Visitorパターン

> **構造を渡り歩きながら仕事をする**


## 概要

データ構造と処理を分離して


# ソース

```php
<?php

/**
 * データ構造と処理を分けて保守性を高める
 * とはいえPHPでは型もオーバーロードもないので
 * 保守性云々の議論は難しい。
 * しかし一つのデータ構造に対する
 * 処理が複数あるときには効果大
 * 「ORマッパーのカスケード処理」
 * 「退会による連鎖削除」
 * 「アカウント凍結」
 */



/**
 * データ構造とアルゴリズムを分離することで
 * 保守性を高める
 * 様々なデータ構造を一度に処理するとき、
 * その一連の処理を一つのVisitorに実装すれば
 * 単にトラバース(横断)するだけで
 * 適切な処理へとディスパッチできる
 * 
 */


/**
 * 訪問者
 */


interface Visitor
{
  public function visit($acceptor);
}


/***
 * 訪問者を受け入れるメソッドだけ用意する
 */

interface Element
{
  public function accept($visitor);
}


/**
 * 具体的な訪問者のビジネスマンで
 * 色々な会社の色々な部署を訪問
 */


class BusinessMan  implements Visitor
{
  /**
   * phpではオーバーロードがないので
   * visit+acceptorのクラス名で呼ばれるメソッドが決定
   * 
   */

  public function visit($acceptor)
  {
    $method = "visit" . get_class($acceptor);
    $this->$method($acceptor);
  }

  /**
   * ラジオ局そのものに訪問したとき
   *
   * @param [type] $acceptor
   * @return void
   */
  public function visitRadioStation($acceptor)
  {
    print $acceptor . "を訪問して色々やります<br>";
    $acceptor->next->accept($this);
  }

  /**
   * ラジオ局のニュース番組部を訪問したときに呼ばれます
   */
  public function visitRadioStation_News($acceptor)
  {
    print $acceptor . "を訪問して色々やります<br>";
  }
}


/**
 * ラジオ局
 * visitorを受け入れる
 */

class RadioStation   implements Element
{
  public function __toString()
  {
    return "ラジオ局";
  }

  /**
   * 訪問者を受け入れる
   */

  public function accept($visitor)
  {
    $visitor->visit($this);
  }
}



/**
 * ラジオ局のニュース番組ぶ
 */




class RadioStation_News  implements Element
{

  public function __toString()
  {
    return "ラジオ局のニュース番組担当";
  }
  public function accept($visitor)
  {
    $visitor->visit($this);
  }
}


$radio = new RadioStation();
$radio->next = new RadioStation_News();
$radio->accept(new BusinessMan());

```
