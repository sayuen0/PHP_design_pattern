# abstractFactoryパターン

## 概要


作り方より先に使い方に着目する



漫画でわかるFactory Methodより

> 作り方より先に使い方に着目する Abstract Factory とは違い、

同じcreateメソッドで呼び出せれば嬉しい。使い方に着目している


## マンガでわかる Abstract Factory

[デザインパターン](https://qiita.com/tags/デザインパターン)[GoF](https://qiita.com/tags/gof)

[![CDD515F3-EE04-4F58-A560-CD5E3E2B57C6.png](https://qiita-user-contents.imgix.net/https%3A%2F%2Fqiita-image-store.s3.ap-northeast-1.amazonaws.com%2F0%2F11525%2Fdd6ad5ee-27a2-6832-541f-86f093f912f7.png?ixlib=rb-1.2.2&auto=format&gif-q=60&q=75&s=a6a0816458311524b09a2b96a2f3aa36)](https://qiita-user-contents.imgix.net/https%3A%2F%2Fqiita-image-store.s3.ap-northeast-1.amazonaws.com%2F0%2F11525%2Fdd6ad5ee-27a2-6832-541f-86f093f912f7.png?ixlib=rb-1.2.2&auto=format&gif-q=60&q=75&s=a6a0816458311524b09a2b96a2f3aa36)

誰か作ってくれる人がいることにして、遊ぶほうに意識が行っちゃってますね。いいですね、これこそオブジェクト指向の醍醐味です。

複雑なものをできるだけシンプルにするには「関心の分離」が重要です。とくに、操作に関する知識と生成に関する知識とを分離するのは良いアイデアです。操作のたびに、どういう作りなのかを気にして `if - else` を書いてしまうと、「ラジコンのプロポをガチャガチャするだけで楽しい」では済まない複雑さになってしまいます。サーボの設定事情などは、どんなちょうぜつ操作をしてもいい感じに動くように生成して、隠蔽すればよいのです。判断を前倒しした結果を生成物に閉じ込めてしまうわけです。

というふうに生成と操作を別のクラスに分離しましょう...で話は終わりません。ここで、操作する人が具体的に誰かに作ってくれと言ってしまう(具象クラス型を利用してしまう)と、操作は生成者に直接依存してしまいます。本当に生成の詳細に無関心でいるためには、作り方だけでなく、誰が作ってくれるのかにさえ関心を払ってはいけないのです。というわけで出てくるのが「作ってくれる誰か」という抽象概念です。依存する先はそこです。

めもりーちゃん(作れないのになんで買ってきた)は姫なので、誰に頼むかまで考えていません。「まあ誰か作ってくれるんでしょ」としか思わないのです。それでいいんです。関心があるのは操作の方なので、そっちに集中してもらうのが健全で、そこまででパッケージを完結させてしまいましょう。あとは単体テストで「誰か」としてモックファクトリを使えば、パッケージに含まれるコードはすべて完成ですね。やりたいことしかしないので、テストケースも簡単です。作ってくれる人は別パッケージの責務なので気にしたら負けです。

要するに、オブジェクトを生成するオブジェクトに関して、このように詳細のわからない依存をいったん抽象のままにして、オブジェクトを利用する方にのみ着目すること、つまり、依存関係逆転原則 (Dependency Inversion Principle = DIP) のファクトリ版が Abstract Factory パターンです。

------

漫画でわかるFactory Methodより

> 作り方より先に使い方に着目する Abstract Factory とは違い、

同じcreateメソッドで呼び出せれば嬉しい。使い方に着目している

## 活かせそうなシナリオを考えてみる

### HTMLフォーム部品生成

- ログインフォーム
- 新規登録フォーム
- 設定フォーム

いずれもFormインタフェースを実装してcreateから生成されるようにするとか





# ソース





```php
<?php
ini_set("display_errors", "1");

/**
 * 単にnewするだけでなく
 * プロパティに依存オブジェクトを設定して
 * 初めて利用可能になるようなオブジェクトにおける
 * プロパティ設定の一貫性を保つために使う
 * 
 */


/**
 * 実ファクトリを用いて
 * 一貫性のあるプロパティを設定することを目的としたパターン
 * 依存性注入によってお株を奪われつつあるらしい
 *
 */


/**
 *  アブストファクトファクトリ
 * 「作る」
 * 何を作るのかは子供による
 * 
 */
interface FashionFactory
{
  public function createTops();
  public function createBottoms();
  public function createCap();
}


/**
 * ファクトリを使ってプロパティを設定される対象
 * 服
 */
class Fashion
{
  private $tops = null;
  private $bottoms = null;
  private $cap = null;

  public function setTops($tops)
  {
    $this->tops = $tops;
  }
  public function setBottoms($bottoms)
  {
    $this->bottoms = $bottoms;
  }

  public function setCap($cap)
  {
    $this->cap = $cap;
  }



  public function getTops()
  {
    return $this->tops;
  }

  public function getBottoms()
  {
    return $this->bottoms;
  }

  public function getCap()
  {
    return $this->cap;
  }
}

/**
 * 実ファクトリその１
 * 和服工場
 */


class JapaneseFashionFactory implements FashionFactory
{
  private static $instance = null;
  public function __construct()
  {
  }

  // singleton?
  public static function getInstance()
  {
    if (self::$instance == null) {
      // 自分をメンバに持つ
      self::$instance = new JapaneseFashionFactory();
    }
    return self::$instance;
  }

  public function createTops()
  {
    return "長着";
  }
  public function createBottoms()
  {
    return "袴";
  }
  public function createCap()
  {
    return "三度笠";
  }
}

/**
 * 実ファクトリ2
 * 洋服工場
 */




class ForeignFashionFactory  implements FashionFactory
{
  private static $instance = null;
  public function __construct()
  {
  }

  public static function getInstance()
  {
    if (self::$instance == null) {
      // 自分をメンバに持つ
      self::$instance = new ForeignFashionFactory();
    }
    return self::$instance;
  }

  public function createTops()
  {
    return "ジャケット";
  }
  public function createBottoms()
  {
    return "ジーンズ";
  }

  public function createCap()
  {
    return "キャップ";
  }
}


// 和服工場
$jpFactory = JapaneseFashionFactory::getInstance();

// 洋服
$foreignFactory = ForeignFashionFactory::getInstance();




// どちらが作ろうがcreate****という呼び出しになっているのがミソ
// 服に和服工場のトップスとボトムズを設定
$jpFashion = new Fashion();
$jpFashion->setTops($jpFactory->createTops());
$jpFashion->setBottoms($jpFactory->createBottoms());
$jpFashion->setCap($jpFactory->createCap());

$foreignFashion = new Fashion();
$foreignFashion->setTops($foreignFactory->createTops());
$foreignFashion->setBottoms($foreignFactory->createBottoms());
$foreignFashion->setCap($foreignFactory->createCap());

var_dump($jpFashion);
var_dump($foreignFashion);

```

