<?php
ini_set("display_errors", 1);

// 初期化に時間のかかるものを必要になるまで後回し
// 代理人で処理をデコレートしたり

/**
 * パイのインタフェース
 * 
 * 
 */


interface IPie
{
  public function addMaterial(String $material);
  public function fill();
}


/**
 * 代理のパイ
 * 材料の追加は仮のパイに任せる
 * 材料を混ぜ込む時に本物のパイを取り出す
 */


class ProxyPie  implements IPie
{
  private $realPie = null;
  private $materials = array();

  /**材料追加 */

  public function addMaterial(String $m)
  {
    if ($this->realPie != null) {
      $this->realPie->addMaterial($m);
    }
    $this->materials[] = $m;
    print $m . "を追加するよ<br>";
  }
  /**
   * 材料を混ぜ込む
   * 
   */

  //  fillするときに初めて本物のパイのfillが呼び出される
  public function fill()
  {
    if ($this->realPie == null) {
      $this->realPie = new RealPie($this->materials);
    }
    $this->realPie->fill();
  }
}


/**
 * 本物のパイ
 * 
 */

class RealPie  implements IPie
{
  private $materials;

  public function __construct($materials)
  {
    $this->materials = $materials;
    print("実物のパイ生地を作り始める<br>");
    sleep(2);
    print("実物のパイ生地を作成。<br>");
  }

  // 材料追加
  public function addMaterial($m)
  {
    $this->materials[] = $m;
  }
  // 混ぜる
  public function fill()
  {
    foreach ($this->materials as $m) {
      print "$m <br>";
    }

    print "材料をパイに詰め込むよ <br>";
  }
}


$proxy = new ProxyPie();
$proxy->addMaterial("人参");
$proxy->addMaterial("よくわからんもの");
$proxy->addMaterial("ケミカルX");
$proxy->fill();

