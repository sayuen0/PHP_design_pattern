<?php
ini_set("display_errors", 1);



/**
 * イベントリスナー
 * サービスを提供するオブジェクトへ
 * 指定のインタフェースを実装したオブジェクトを
 * 事前登録
 * 指定のタイミングで処理を働きかける
 * 
 * JSのDOMはだいたいこれを実装している
 * 
 */



/**
 * ラジオそのもののインタフェース
 * 発信役
 */
interface ISubject
{
  public function add($obserrer);
  public function remove($obserrer);
  public function notify($e);
}


/**
 * リスナー
 * 聞く体勢だけ持ってればいい
 * 
 */


interface IObserver
{
  public function receive($music);
}


/**
 * 実際のラジオ
 */


class Radio  implements ISubject
{
  // リスナー全員
  private $observers = array();


  /**
   * リスナーの「視聴契約」
   */
  public function add($observer)
  {
    $this->observers[] = $observer;
  }

  /**
   * リスナーの「視聴解約」
   */
  public function remove($observer)
  {
    foreach ($this->observers as $obs) {
      if ($observer != $obs) {
        $this->observers[] = $obs; //observerを上書きしてるのか？これ動くの？
      }
    }
  }

  public function notify($e)
  {
    foreach ($this->observers as $obs) {
      $obs->receive($e);
    }
  }

  public function broadCast($music)
  {
    $this->notify($music);
  }
  public function talk()
  {
    $this->notify("DJの喋り");
  }
}


/**
 * リスナー
 */


class Listenter  implements IObserver
{
  private $name;

  public function __construct($name)
  {
    $this->name = $name;
  }

  public function receive($music)
  {
    print "ラジオネーム $this->name さんが $music " . "を聞きました <br>";
  }
}


$radio = new Radio();
$radio->add(new Listenter("Larry"));
$radio->add(new Listenter("Gates"));
$radio->add(new Listenter("Jobs"));
$radio->broadCast("SHIELD TRIGGER! ~クロック8枚~");
$radio->talk();
