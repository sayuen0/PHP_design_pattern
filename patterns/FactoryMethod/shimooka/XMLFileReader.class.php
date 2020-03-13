<?php
require_once("Reader.class.php");

class XMLFileReader  implements Reader
{

  /**
   * 内容を表示するファイル名
   *
   * @access private
   */
  private $filename;


  /**
   * データを扱うハンドラ名
   *
   * @access private
   */
  private $handler;

  public function __construct($filename)
  {
    if (!is_readable($filename)) {
      throw new Exception('file "' . $filename . '" is not readable !');
    }
    $this->filename = $filename;
  }

  /**
   * xmlを開く
   *
   * @return void
   */
  public function read()
  {
    $this->handler = simplexml_load_file($this->filename);
  }


  /**
   * 文字コードの変換を行います
   */
  private function convert($str)
  {
    return mb_convert_encoding($str, mb_internal_encoding(), "auto");
  }


  /**
   * xmlをhtmlに変換する
   *
   * @return void
   */

  public function display()  {
    foreach ($this->handler->artist as $artist) {
      echo "<b>" . $this->convert($artist['name']) . "</b>";
      echo "<ul>";
      foreach ($artist->music as $music) {
        echo "<li>";
        echo $this->convert($music['name']);
        echo "</li>";
      }
      echo "</ul>";
    }
  }
}
