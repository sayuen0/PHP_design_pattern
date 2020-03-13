<?php

/**
 * クローンをいじろうが元のオブジェクトに影響を与えない
 * 
 * PHPにはもともとcloneの機能があるのでそれを用いる
 * cloneの機能がない言語においては
 * 明示的に深いコピーをしたインスタンスを返す
 * 
 * 
 */






class Prototype
{
  private $values = array();
  public function __set($key, $val)
  {
    $this->values[$key]   = $val;
  }

  public function __get($key)
  {
    return $this->values[$key];
  }

  /**
   * phpのコピーはシャローコピーなので
   * 深いコピーを作成するためにマジックメソッドcloneを作る
   * 
   */
  public function __clone()
  {
    foreach ($this->values as $key => $val) {
      if (is_object($val)) {
        $this->key = clone $val;
      } else {
        $this->key = $val;
      }
    }
  }
}


class Child
{
  private $values = array();
  public function __set($key, $val)
  {
    $this->values[$key] = $val;
  }

  public function __get($key)
  {
    return $this->values[$key];
  }
}



