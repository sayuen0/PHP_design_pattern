<?php  // ストラテジパターン

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



function main()
{
  $person = new ConcreteStrategy(new LadyStrategy());
  $person->behave();
  $person = new ConcreteStrategy(new OlomanStrategy());
  $person->behave();
  $person = new ConcreteStrategy(new AngryManStrategy());
  $person->behave();
}

main();