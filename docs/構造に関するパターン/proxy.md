# Proxy

> **必要になってから作る**

## 概要

インタフェース(メソッド名)が同じでより軽いオブジェクトを挟んで負荷対策

日常は代用品のインタフェースを呼び出して、使う時になったら初めて本物のインタフェースを代用品経由で呼び出す

## 登場人物

- Subject: 主体。RealSubjectとProxy共通のインタフェース
- Proxy: 代理人。
  - Clientからの要求をできるだけ処理して、自分では処理できないときに限りRealSubjectを生成
  - Subjectを実装
- RealSubject: 実際の主体
- Client:利用者。Subjectを利用


## クラス図

![400px\-Proxy\_pattern\_diagram\.svg\.png \(400×223\)](https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Proxy_pattern_diagram.svg/400px-Proxy_pattern_diagram.svg.png)

## やり方

<!-- TODO:add #3 -->

## メリット

### メモリ節約

- RealSubjectはクソ重いオブジェクトであり、生成に時間がかかる場合を想定する
  - プリンタ
  - 画像
- 簡単な仕事はProxyにやらせて必要になってから重い仕事を本物にやらせれば良い


### 分割統治

- やろうと思えばRealSubjectに最初から遅延評価(必要になってからインスタンス生成する)を組み込むこともできなくもない
- しかしインタフェースで分けることで、**Proxyにいくら処理を追加しても、RealSubjectには影響はない。**分割統治である。
- 遅延評価する必要がないなら最初からRealSubjectをnewすればよく、それがProxyの機能を使う/使わないの選択として表現される

## 関連

### Flyweight

- Flyweightの実現手段としてのProxy。クソ重いオブジェクトの生成を、Proxyを代わりに生成して同じクソ重いオブジェクトを参照させるなど


# ソース

```php
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
 * 生成に時間がかかる
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

```
