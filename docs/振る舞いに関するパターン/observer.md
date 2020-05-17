# Observerパターン

> **状態の変化を通知する**

## 概要

別名**Pub-Sub(Publish-Subscribe)**パターン

- Publish: 発行
- Subscribe: 購読


## 登場人物

- Subject: 観察される側のインタフェース
  - Observerに自身の変化をnotifyする
- ConcreteSubject
- Observer: 監視役。Subjectから「状態が変わりましたよ」と通知を受けるインタフェース
  - 一つのSubjectを監視する**Observerは複数存在して良い**
- ConcreteObserver

## クラス図

![Observer\-pattern\-class\-diagram\.png \(600×320\)](https://upload.wikimedia.org/wikipedia/commons/e/e2/Observer-pattern-class-diagram.png)

## やり方

- SubjectにObserver達を持たせる
- Observerにupdate(Subjectの状態変化があったことを受け取り、何かする)を実装
- Subjectの状態変化があったら、Observer全員に処理を促す
  - その際Subject自身のインスタンス情報をObserverに渡すと、状態ごとの何かができていいよね


## メリット(用途)

交換可能性

- ConcreteSubjectはObserverには依存しているがConcreteObserverには依存していない
- ConcreteObserverはSubjectには依存しているがConcreteSubjectには依存していない

## 関連

- Meditator
  - 共通点: 複数の対象に状態変化を通知
  - 相違点(目的の違い)
    - Mediator: **処理を中央化**する
    - Observer: 個々に状態変化を通知して**同期を取る**

## ソース

### PHP

```php
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


class Radio implements ISubject
{
  // リスナー全員
  private $observers = array();


  /**
   * add
   * リスナーの「視聴契約」
   */
  public function add($observer)
  {
    $this->observers[] = $observer;
  }

  /**
   * remove
   * リスナーの「視聴解約」
   */
  public function remove($observer)
  {
    foreach ($this->observers as $obs) {
      if ($observer != $obs) {
        $this->observers[] = $obs;
        //合致した要素を削除
      }
    }
  }

/**
 * notify
 * 自身の状態変化を通知する
 */
  public function notify($e)
  {
    foreach ($this->observers as $obs) {
      $obs->receive($e);
    }
  }

/**
 * 
 * 「音楽をかける」という状態変化
 */
  public function broadCast($music)
  {
    $this->notify($music);
  }

  
  /**
   * 「トークする」状態変化
   */
  public function talk()
  {
    $this->notify("DJの喋り");
  }
}


/**
 * リスナー
 */


class Listenter implements IObserver
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
$radio->add(new Listenter("flat"));
$radio->add(new Listenter("Macchie"));
$radio->add(new Listenter("Rij"));
$radio->broadCast("SHIELD TRIGGER! ~クロック8枚~");
$radio->talk();
```

## 所感

上のプログラムの違和感

普通ラジオリスナーは自分の聞いているラジオの内容はわかるが、ラジオパーソナリティは自分を聞いているラジオリスナーを把握しないだろう

つまり、依存関係逆だろう。
