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
