<?php
ini_set("display_errors", "1");
ini_set("safe_mode", 1);
/**
 * composite: 複合
 * 入れ子構造に同じインタフェースを実装して
 * 同一に扱う
 * 
 */

interface Removable
{
  public function remove();
}


class RemovableDirectory  implements Removable
{

  private $path;

  public function __construct($path)
  {
    if (!is_dir($path)) {
      throw new Exception("ディレクトリではありません");
    }
    $this->path = preg_replace("#/$#", "", $path);
  }

  public function getList()
  {
    $result = array();
    $d = opendir($this->path);
    while ($f = readdir($d)) {
      if (preg_match("#^\.+$#", $f)) {
        continue;
      }
      $path = $this->path . "/" . $f;
      if (is_file($path)) {
        $result[] = new File($path);
      } elseif (is_dir($path)) {
        $result[] = new RemovableDirectory($path);
      } else {
        throw new Exception("ファイルでもディレクトリでもありません");
      }
    }
    return $result;
  }

/**
 * getList("tmp/composite")
 *  opendir("tmp/composite")
 *   $f = tmp/composite/hoge
 *   $f = tmp/composite/hoge
 *
 * @return void
 */
  public function remove()
  {
    $result = array();
    var_dump($this->getList());
    foreach ($this->getList() as $obj) {//$obj = RemovableDirectory()
      foreach ($obj->remove() as $log) {
        $result[] = $log;
      }
      $result[] = "D=>" . $this->path;
      rmdir($this->path);
      return $result;
    }
  }
  public function makeDirectory($name)
  {
    mkdir($this->path . "/" . $name);
  }
}


class File  implements Removable
{
  private $path;

  public function __construct($path)
  {
    if (!is_file($path)) {
      throw new Exception("ファイルではありません");
    }
    $this->path = preg_replace("#/$#", "", $path);
  }

  public function remove()
  {
    unlink($this->path);
    return array("F=>" . $this->path);
  }

  public function saveFile($name, $data)
  {
    file_put_contents($this->path . "/" . $name, $data);
  }
}
