<?php

/**State */
interface Manual
{
  public function hehave();
}

class LadyManual implements Manual
{
  public function behave()
  {
    print("本当の親のように甘える");
  }
}

class OldGuyManual  implements Manual
{
  public function behave()
  {
    print("持っているものを褒める");
  }
}


class AngryManManual  implements Manual
{
  public function behave()
  {
    print("子供らしく振舞う");
  }
}


// state

class StateContext  
{
  private $state;
  
  public function __construct($age){
  $this->setTargetAge($age);
  }

  public function setTargetAge($age)
  {
    if ($age>=20 &&$age<=40) {
      $this->state = new LadyManual();
    }elseif ($age>=40 && $age<=60) {
      $this->state = new AngryManManual();
    }elseif ($age > 60) {
      $this->state = new OldGuyManual();
    }else {
      throw new Exception("そんな人よく知らんよ");
    }
  }

  public function behave()
  {
    $this->state->behave();
  }
}

function main (){
  $human = new StateContext(20);
  $human->behave();
  $human->setTargetAge(41);
  $human->behave();
  $human->setTargetAge(61);
  $human->behave();

}





