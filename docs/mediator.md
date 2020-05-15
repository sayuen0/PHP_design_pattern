# Mediatorパターン


## 概要

Mediator:調停者に全て投げる


## メリット

### 疎結合の実現

例えば、100個のオブジェクトが相互にメッセージを送りあうとする
1このオブジェクトはそれぞれが99個の相手へのアクセスを持つので、
99^2 = 9801の関係グラフ線ができるようになる。

ところがMediatorをかまして1個のオブジェクトは1人のMediatorとだけやり取りするようにすると、
Mediatorが100人のアクセスを持っていれば9700個の関係グラフ線を節約できる




## 登場人物

- メディエータ:調停者。コリーグAの相談をコリーグBに投げる
- コリーグ: 同僚。メディエータに対してだけ相談を投げる、コリーグからのメッセージを受け取る


- mediatorには

## デメリット

Mediatorの処理は複雑になる。あらゆる調停に関する処理、すなわち個々のオブジェクトに関する情報を全て有していないといけないため。





# ソース

```php
<?php
ini_set("display_errors", 1);

/**
 * 疎結合
 * 直接具体的なインスタンス同士を操作させず
 * Mediatorを通じて操作させる
 * 相手が実際に誰であるか実際は何をしているかは知らせない
 * お互いの平和を守る
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


class Hero implements Mediator
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

```
