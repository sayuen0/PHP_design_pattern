# Memento

> **状態を保存する**

## 概要

やり直しのスナップショットをとって置く

インスタンスを復元したいとき、アクセス修飾子をprivate以外にしないといけなくなる(しなくてもいいけど、内部構造に依存したプログラムになる。**カプセル化の破壊**)




### ミソ

スナップショットは実態よりはるかに軽いもの
なのでケアテイカーはバックアップをいくらでもスタックしておける
オブジェクトそのものでなくその属性のコピーなどでも良し


## 登場人物

- オリジネイター：リアルな事象。メメントを提供したり自分をメメントで更新したり
- ケアテイカー：適切なタイミングでオリジネイターのバックアップを残す
  - まずオリジネイターに「バックアップを取る」ことを通知
  - オリジネイターはメメントを作成する
  - ケアテイカーはそのメメントを受け取り、保存する
  - **狭いインタフェース**しか使えない。メメントはひとかたまりのブラックボックスとして置いておく
- メメント：バックアップ。オリジネイターの内部情報を持つ
  - 狭いインタフェース: ケアテイカーが利用できるインタフェース
    - ここでの狭いとは「内部状態を操作できる度合いが少ない」publicなインタフェース
  - 広いインタフェース: メメントはケアテイカーやMainが作るのではなく、オリジネイター(同一パッケージ)しか作れない
    - 広いとは、内部状態をいじれるpackage privateなインタフェース



## クラス図

![memento\.gif \(442×157\)](https://www.dofactory.com/images/diagrams/net/memento.gif)


## ユースケース

### Git

「スナップショット」がそのままメメントだし、オリジネイターはソースコード本体。本体のバックアップではなく圧縮ファイルを取っておいて、好きなところまで巻き戻しを行える。

# ソース

```php
<?php

/**
 * オブジェクトのundoを実装する
 * 
 * mementoとは「忘れ形見」
 * 処理前の情報を残しておいてそれを再現するといったところだろうか
 * Commandより平易な実装
 */

/**
 * オリジネイター：操作対象オブジェクト
 * ケアテイカー：メメントを記憶するオブジェクト
 * メメント：状態オブジェクト
 */


//  Originator

class Article
{
  private $subject = null;
  private $body = null;
  private $datetime = null;

  public function setSubject($s)
  {
    $this->subject = $s;
  }

  public function setBody($s)
  {
    $this->body = $s;
  }

  public function setDatetime($d)
  {
    $this->datetime = $d;
  }

  public function getSubject()
  {
    return $this->subject;
  }
  public function getBody()
  {
    return $this->body;
  }
  public function getDatetime()
  {
    return $this->datetime;
  }

  // memento作成
  public function createMemento()
  {
    $obj = new ArticleMemento();
    $obj->setSubject($this->getSubject());
    $obj->setBody($this->getBody());
    $obj->setDatetime($this->getDatetime());
    return $obj;
  }

  // mementoをセットしてその状態を復元
  public function setMemento($obj)
  {
    $this->setSubject($obj->getSubject());
    $this->setBody($obj->getBody());
    $this->setDatetime($obj->getDatetime());
  }
}


// memento: 記憶するやつ

class ArticleMemento
{
  private $subject = null;
  private $body = null;
  private $datetime = null;

  public function setSubject($s)
  {
    $this->subject = $s;
  }

  public function setBody($s)
  {
    $this->body = $s;
  }

  public function setDatetime($d)
  {
    $this->datetime = $d;
  }

  public function getSubject()
  {
    return $this->subject;
  }
  public function getBody()
  {
    return $this->body;
  }
  public function getDatetime()
  {
    return $this->datetime;
  }
}



// CareTaker: メメントを保持するやつ

class ArticleCaretaker
{
  private $memento = null;

  public function getMemento()
  {
    return $this->memento;
  }

  public function setMemento($memento)
  {
    $this->memento = $memento;
  }
}


// コントローラ

date_default_timezone_set("Asia/Tokyo");
function say($s)
{
  print $s . "<br>";
}


say("初期状態");

$article = new Article();
$article->setSubject("変更前の記事の件名");
$article->setBody("変更前の記事の本文");
$article->setDatetime(date("Y/m/d H:i:s"));

say($article->getSubject());
say($article->getBody());
say($article->getDatetime());

// ケアテイカーに今のArticleのメメントをセットし記憶
$act = new ArticleCareTaker();
$act->setMemento($article->createMemento());

say("変更");
$article->setSubject("変更後の記事の件名");
$article->setBody("変更後の記事の本文");
$article->setSubject(date("Y/m/d H:i:s", strtotime("+1hour")));

say($article->getSubject());
say($article->getBody());
say($article->getDatetime());


say("復元");
// Articleにさっきケアテイカーに保存したメメントをセットして復元
$article->setMemento($act->getMemento());

say($article->getSubject());
say($article->getBody());
say($article->getDatetime());

```
