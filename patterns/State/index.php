<?php

/**ステートパターン
 * 
 * State: 状態ごとの振る舞いを定義するメソッドの集まり
 * ConcreteState Stateで定義されたメソッドを具体的に実装
 * Context:ConcreteStateを持ち、Stateを利用するためのAPIを持つ
 */

/**
 * state
 */
interface Manual
{
  public function behave();
}

/**
 * concreteState
 */
class LadyManual implements Manual
{
  public function behave()
  {
    var_dump("本当の親のように甘える");
  }
}

class OldGuyManual  implements Manual
{
  public function behave()
  {
    var_dump("持っているものを褒める");
  }
}


class AngryManManual  implements Manual
{
  public function behave()
  {
    var_dump("子供らしく振舞う");
  }
}


// Context :state自身
class StateContext
{
  private $state;

  public function __construct($age)
  {
    $this->setTargetAge($age);
  }

  // concreteStateを持つ
  public function setTargetAge($age)
  {
    if ($age >= 20 && $age <= 40) {
      $this->state = new LadyManual();
    } elseif ($age >= 40 && $age <= 60) {
      $this->state = new AngryManManual();
    } elseif ($age > 60) {
      $this->state = new OldGuyManual();
    } else {
      throw new Exception("そんな人よく知らんよ");
    }
  }

  //concreteStateを利用するAPIを持つ
  public function behave()
  {
    $this->state->behave();
  }
}

function main()
{
  $human = new StateContext(20);
  $human->behave();
  $human->setTargetAge(41);
  $human->behave();
  $human->setTargetAge(61);
  $human->behave();
}


main();