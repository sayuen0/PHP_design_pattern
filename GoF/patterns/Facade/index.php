<?php

/**
 * 窓口を統一して複雑度を追い出す
 * MVCのC
 * コツは
 * 複雑さはサブシステムに追い出すこと
 * 一つのファサードを多機能にしないこと
 */


/**
 * facade: 窓口。workerのdoMethodを管理
 * runで全て実行
 * worker: doMethodを持つ
 * 
 */


class Facade
{
  public function run()
  {
    $obj1 = new Worker1();
    $obj2 = new Worker2();
    $obj3 = new Worker3();

    if ($obj1->doMethod()) {
      return $obj2->doMethod();
    } else {
      return $obj3->doMethod();
    }
  }
}


interface IWorker
{
  public function doMethod();
}

class Worker1 implements IWorker
{
  public function doMethod()
  {
    return true;
  }
}

class Worker2 implements IWorker
{
  public function doMethod()
  {
    return "worker2";
  }
}



class Worker3 implements IWorker
{
  public function doMethod()
  {
    return "worker3";
  }
}


$obj = new Facade();

// workerが見えないのでスッキリする

print $obj->run();
