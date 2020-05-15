# ソース

```php
<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

/**
 * 
 * Chain Of Responsibility
 * 「責任の連鎖」
 * 「優先度付きの処理フローを定義」
 * ザ・たらい回しパターン
 * オブジェクトは受け取ったものを
 * 自分で処理できるなら処理
 * 処理できないなら「次の人へお願い」
 * 
 */


/**
 * 「遺跡の部屋の名前を判断する」多重分岐を
 * ケースを分割統治して解決する
 * 
 */


/**
 * ダンジョンクラス
 * レベルが高いダンジョンほど攻略難
 */


class Dungeon
{
  private $level = null;
  public function __construct($level)
  {
    $this->level = $level;
  }

  public function getLevel()
  {
    return $this->level;
  }
}


// /**
//  * 冒険者抽象クラス
//  * 自分ではダンジョンをクリアできないときのために次の冒険者を保持
//  * 
//  */

abstract class Adventurer
{
  protected $level;
  private $name;
  private $next;


  /**
   * 冒険者名を保持
   *
   * @param string $name
   */
  public function __construct($name)
  {
    $this->name = $name;
  }

  /**
   * 自分ではクリアできない
   * 次に任せる人をセットする
   * @param $next 冒険者を継承した何か
   */

  public function setNext(Adventurer $next)
  {
    $this->next = $next;
    return $this->next;
  }

  /**
   * メイン処理
   * 自分がダンジョンをクリアできるのならclear
   * できないなら次の人に任せる
   * @param $dungeon
   */
  public function challenge($dungeon)
  {
    if ($this->canClear($dungeon)) {
      $this->clear($dungeon);
    } elseif ($this->next != null) {
      print "$this は クリアできないので$this->next にお任せします. <br> ";
      $this->next->challenge($dungeon);
    } else {
      $this->fail($dungeon);
    }
  }


  public function __toString()
  {
    return $this->name;
  }
  /**
   * ダンジョンをクリアできるかどうかの判定はサブクラスに任せる
   *
   * @param [type] $arg
   * @return void
   */
  public abstract function canClear(Dungeon $dungeon);

  /**
   * ダンジョンクリア時に呼ばれる
   */
  protected function clear(Dungeon $dungeon)
  {
    print $this . "がレベル" . $dungeon->getLevel() . "ダンジョンを攻略 <br>";
  }

  /**
   * たらい回しにされた結果、誰も処理できないときに呼ばれる
   *
   * @param [type] $arg
   * @return void
   */
  protected function fail($dungeon)
  {
    print "誰も攻略できない <br>";
  }
}


/**
 * 初心者の冒険者クラス
 */



class Beginner extends Adventurer
{

  public function __construct($name, $level)
  {
    parent::__construct($name);
    // $this->name = $name;
    $this->level  = $level;
  }

  public function canClear(Dungeon $dungeon)
  {
    return (20 > $dungeon->getLevel() && $dungeon->getLevel() < $this->level);
  }
}


/**
 * 中級者
 */
class Intermediate extends Adventurer
{

  public function __construct($name, $level)
  {
    parent::__construct($name);
    $this->level  = $level;
  }

  /**
   * レベル40未満のダンジョン
   * かつ自身のレベルより低いダンジョンならクリアできる
   */

  public function canClear(Dungeon $dungeon)
  {
    return 40 > $dungeon->getLevel() && $dungeon->getLevel() < $this->level;
  }
}


/**
 * 上級者。
 * 自分のレベルを持たない。カンストしたとでも思えば良い
 */
class Expert extends Adventurer
{

  public function __construct($name)
  {
    parent::__construct($name);
  }

  /**
   * レベル100未満のダンジョン
   * なら問答無用でクリアできる
   */

  public function canClear(Dungeon $dungeon)
  {
    return 100 > $dungeon->getLevel();
  }
}


// main

$beginner = new Beginner("初心者", 5);
$intermediate = new Intermediate("中級者", 24);
$expert = new Expert("上級者");


// 初心者、中級者、上級者の順に処理を任せる;
$beginner->setNext($intermediate)->setNext($expert);

// 挑ませる

$beginner->challenge(new Dungeon(15));
$beginner->challenge(new Dungeon(4));
$beginner->challenge(new Dungeon(60));
$beginner->challenge(new Dungeon(100));



// 動的に連鎖を変えられる
$beginerB = new Beginner("初心者B", 5);
$interB = new Intermediate("中級者B", 24);
$expertB = new Expert("上級者B");

$expertB->setNext($beginerB)->setNext($interB);
$expertB->challenge(new Dungeon(15));
$expertB->challenge(new Dungeon(4));
$expertB->challenge(new Dungeon(60));
$expertB->challenge(new Dungeon(100));

```
