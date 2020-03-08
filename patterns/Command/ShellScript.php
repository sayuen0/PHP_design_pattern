<?php
/**
 * Client
 */
class ShellScript
{
  public $commands  = array();
  private $position  = 0;

  public function add($cmd)
  {
    $this->commands[] = $cmd;
  }

  public function next($times = 1)
  {
    $result = array();
    for ($i = 0; $i < $times; $i++) {
      $result[] = $this->commands[$this->position++]->execute();
    }
    return $result;
  }

  public function undo($times = 1)
  {
    $result = array();
    for ($i = 0; $i < $times; $i++) {
      $result[] = $this->commands[--$this->position]->undo();
    }
    return $result;
  }

  public function run()
  {
    return $this->next(count($this->commands) - $this->position);
  }
}
