<?php
ini_set("display_errors", 1);

/**
 * 直接具体的なインスタンス同士を操作させず
 * Mediatorを通じて操作させる
 * 相手が実際に誰であるか実際は何をしているかは知らせない
 * お互いの平和を守る
 * 
 */

/**
 * 仲介者 Mediator
 */


interface Mediator
{
  public function addColleague($assistant);
}

/**
 * 同僚
 * 仲介役をセットする
 * 同じ相談者に対して相談する
 */


interface Colleague
{

  public function setMediator($mediator);
  public function consult($to, $message);
}


class Hero  implements Mediator
{
  private $colleagues = array();
  /**
   * 管轄下に置かれる部下を追加
   */

  public function addColleague($assistant)
  {
    $this->colleagues[$assistant->getName()] = $assistant;
    $assistant->setMediator($this);
  }

  /**
   * from部下からto部下へ相談された内容を伝える
   * @param $from 部下
   * @param $to $部下
   * @param $message 相談内容
   */
  public function sendMessage($from, $to, $message)
  {
    if (array_key_exists($to, $this->colleagues)) {
      print $from->getName() . "から" . $this->colleagues[$to]->getName() . "へ";
      $this->colleagues[$to]->receiveMessage($message);
    } else {
      print "知らない部下です<br>";
    }
  }
}


/**
 * アシスタント
 * 他の部下に相談する前に一度仲介役を介す
 */


class Assistant  implements Colleague
{
  private $name;
  private $mediator;

  public function __construct($name)
  {
    $this->name = $name;
  }

  /**
   * 何か相談するときに報告する仲介役の設定
   */

  public function setMediator($mediator)
  {
    $this->mediator = $mediator;
  }
  public function getName()
  {
    return $this->name;
  }

  /**
   * $toのぶかに対して相談するが
   * 自分は誰々に相談したいと、仲介役を中継
   */
  public function consult($to, $message)
  {
    $this->mediator->sendMessage($this, $to, $message);
  }

  /**
   * 相談内容を受け取る
   */

  public function receiveMessage($message)
  {
    print "[$message] <br>";
  }
}


$hero = new Hero();
$yellow = new Assistant("yellow");
$blue = new Assistant("blue");

$hero->addColleague($yellow);
$hero->addColleague($blue);

$blue->consult("yellow", "how are you? ");
$yellow->consult("blue", "soso.");
