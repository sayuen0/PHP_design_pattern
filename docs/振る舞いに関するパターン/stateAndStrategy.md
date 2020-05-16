# State & Strategy パターン

# Strategy

> **アルゴリズムをごっそり切り替える**


## 登場人物

- Strategy: 戦略名インタフェース
- ConcreteStrategy: 戦略を実装 **(具体的な作戦、方策、方法、アルゴリズムの切り替え)**
- Context: Strategy利用者



## クラス図

![500px\-StrategyPatternClassDiagram\.svg\.png \(500×213\)](https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/StrategyPatternClassDiagram.svg/500px-StrategyPatternClassDiagram.svg.png)

## やり方

- ConcreteStrategy達にStrategyを実装させる
- Contextは**ConcreteStrategyインスタンスを持つ**が、Strategyインタフェースを呼び出す


## メリット(用途)


## 所感

これただのインタフェースの使い方では?

# ソース

```php
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

// ストラテジパターン

/**
 * Strategy 抽象的な戦略を定義する
 * ConcreteStrategy Strategy 具体的な戦略を定義する
 * Context ConcreteStrategyを所有する Strategyを利用する
 */

interface Strategy
{
  public function behave();
}

class LadyStrategy  implements Strategy
{
  public function behave()
  {
    var_dump("本当の親のように甘える");
  }
}

class OlomanStrategy  implements Strategy
{
  public function behave()
  {
    var_dump("持っているものを褒める");
  }
}


class AngryManStrategy  implements Strategy
{
  public function behave()
  {
    var_dump("子供らしく振舞う");
  }
}


// Context : strategy本人

class ConcreteStrategy
{
  private $strategy;

  public function __construct($strategy)
  {
    $this->strategy = $strategy;
  }
  public function behave()
  {
    $this->strategy->behave();
  }
}



function main2()
{
  $person = new ConcreteStrategy(new LadyStrategy());
  $person->behave();
  $person = new ConcreteStrategy(new OlomanStrategy());
  $person->behave();
  $person = new ConcreteStrategy(new AngryManStrategy());
  $person->behave();
}

main();
main2();

```
