# Factory Methodパターン

本のソースに誤りがあり、趣旨がよくわからないので、エッセンスだけを抜き出し


別事例: 
- [PHPによるデザインパターン入門 \- Factory Method〜生成処理と使用処理を分離する \- Do You PHP はてブロ](http://shimooka.hateblo.jp/entry/20141215/1418620242)


## メリット


###  オブジェクトの生成過程の隠蔽と集中管理


オブジェクト生成の方法に注目したパターン



単純な生成クラスではなくテンプレートメソッド的なオブジェクト準備の過程をabsractメソッドに定義して、オブジェクト生成と準備を抽象化多様なインスタンス生成を請け負うオブジェクト生成は強い依存を生むので、切り離すだけでも大きなメリットがある



復習:
templatemethodでは、処理の流れを実際の処理から抽象化した
それぞれdoActionという名前で、
validateしてエラーがあればエラーを投げて、
なければdoMainするという流れを踏んだ


## シナリオ CSVかXMLかの方

今回の実装。上記リンクから趣旨を抜き出す

- ある既存のCSV出力メソッドを,XMLにも対応させたいとする
- ifでCSVかXMLか分岐させればできそう
- しかしさらにファイル形式の対応を増やしていけば、if文が増えるばかり

ユーザがやりたいことはファイル形式が何であれ

1. 読み込む read
2. 表示する display

これだけ。

具体的な読み込み方法や表示方法はそれぞれのファイル形式に対応させたファクトリに任せる


## シナリオ システム開発

ベンダー企業とクライアントがいる

とあるクライアントはデータセンターを運営しようとして、データセンターシステムを外注しようとする。
とあるクライアントはPOSシステムを外注しようとする。

クライアントはベンダーの営業(ConcreteFactory)に
**発注して納品待ち** をする。だけ。どんな開発体制が取られるかは(監査を入れるでもしようとしなければ)ベンダー側に任せる

ベンダーは受注内容から
データセンターシステムの受注ならその道のスペシャリストに、
POSシステムならその道のスペシャリストに開発をさせる。

ベンダーのエンジニアは共通して「開発」と「納品」ができるが、それぞれ手法は専門領域や開発スタイルから完全に異なる


## シナリオ 料理

釣りが趣味のおっさんと持込OKレストラン

おっさんは釣った魚をレストランに渡して、調理済みの魚料理をもらう
レストランは魚の種類によって、一番美味しく食べられる調理方法が可能な料理人に魚を調理させる


登場人物

- おっさん: クライアント
- レストラン：ファクトリ
- 料理人：プロダクトの作り手。ファクトリに生成される
- 料理：プロダクト


## クラス図

![](https://upload.wikimedia.org/wikipedia/commons/8/8e/Factory_Method_UML_class_diagram.svg)



## マンガでわかる Factory Method


[![136D975D-2C6E-4860-A523-C1EBB89B976E.png](https://qiita-user-contents.imgix.net/https%3A%2F%2Fqiita-image-store.s3.ap-northeast-1.amazonaws.com%2F0%2F11525%2F9f3c67b2-0fa4-5c1c-f064-6612df9e3a84.png?ixlib=rb-1.2.2&auto=format&gif-q=60&q=75&s=359fa8f84b7f2085ac8e0d40ce594191)](https://qiita-user-contents.imgix.net/https%3A%2F%2Fqiita-image-store.s3.ap-northeast-1.amazonaws.com%2F0%2F11525%2F9f3c67b2-0fa4-5c1c-f064-6612df9e3a84.png?ixlib=rb-1.2.2&auto=format&gif-q=60&q=75&s=359fa8f84b7f2085ac8e0d40ce594191)

ミニ四駆も実はなかなか難しいんだけど、基本キットや難しいところは模型屋のおじさんが準備してくれてるとおりにやればいいので、小学生でも参加できる体験教室ができるんですね。

おじさんが渡してくれるキットのように、作り方の大枠はあらかじめ準備された抽象 (ただしそれだけでは目的物は完成しない) とし、難しい工程はおじさんがやるってことになってる、そんな生成フレームワークを考えるんですよ。

体験教室の各参加者は、そのしくみを継承したファクトリになりきって、誰でもできるパーツを選ぶ工程 (簡単だけど重要) と、走行性能に関係しない塗装工程 (これもオリジナル感を出すのにとても重要) を、自分好みで実装したらオッケー。

これならオリジナルミニ四駆でも生産性が安定するし、模型屋さんもカスタムパーツじゃんじゃん売れますね。

Factory Method は、多様な具象クラスを抽象クラスのメソッドの穴埋めで完成させる [Template Method](https://qiita.com/tanakahisateru/items/2dbeb7e5bdd3af8ec3d0) のファクトリ版とも言えます。

で、ここ注意! 名前は似ているけれど、作り方より先に使い方に着目する [Abstract Factory](https://qiita.com/tanakahisateru/items/af019c95295469c6606b) とは違い、こっちは、終始作り方に着目するのがポイントですよ。この差がめちゃくちゃ重要。

意味が排他的な関係じゃない、というかむしろ補完関係なので、 「クライアントコードが求める Abstract Factory を、Factory Method パターンで提供する」なんてことも普通にあります。このコードは何のパターンか、ではなく、コードの関係に着目してどうパターンを見出すか、なのです。


# ソース

```php
<?php
ini_set("display_errors", "1");


/**
 * オブジェクトの生成過程の隠蔽と集中管理
 * 
 * 単純な生成クラスではなく
 * テンプレートメソッド的なオブジェクト準備の過程を
 * absractメソッドに定義して、
 * オブジェクト生成と準備を抽象化
 * 多様なインスタンス生成を請け負う
 * オブジェクト生成は強い依存を生むので、
 * 切り離すだけでも大きなメリットがある
 */


/**
 * 復習:
 * templatemethodでは、処理の流れを実際の処理から抽象化した
 * それぞれdoActionという名前で、
 * validateしてエラーがあればエラーを投げて、
 * なければdoMainするという流れを踏んだ
 */




abstract class ModelFactoryBase
{
  private static $instances = array();
  private function __construct()
  {
  }

  public static function getInstance($class)
  {
    if (!in_array($class, self::$instances)) {
      self::$instances[$class] = new $class;
    }
    return self::$instances[$class];
  }

  public function create($name)
  {
    $class = "${name}Model";
    if (!class_exists($class)) {
      require "$class.php";
      $obj = new $class;
      $this->setProperties($obj);
      return $obj;
    }
  }
  abstract public function setProperties($obj);
}


class ModelFactoryA extends ModelFactoryBase
{

  public function setProperties($obj)
  {
    $obj->setName("FromA");
  }
}
class ModelFactoryB extends ModelFactoryBase
{

  public function setProperties($obj)
  {
    $obj->setName("FromB");
  }
}


abstract class ModelBase
{
  protected $rows  = array();
  private $name = null;
  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function __construct()
  {
    $this->fillData();
  }

  public abstract function fillData();
}


class CSVModel extends ModelBase
{
  public function fillData()
  {
    ob_start();
?>
    1, name1, hoge@example.com
    2, name2, fuga@example.com
    2, name3, piyo@example.com
    <?php
    foreach (explode("\n", ob_get_clean()) as $line) {
      if (!trim($line)) {
        continue;
      }
      $row = str_getcsv($line);
      $this->rows[trim($row[0])] =  (object) array(
        "id" => trim($row[0]),
        "name" => trim($row[1]),
        "mailAddress" => trim($row[2]),
      );
    }
  }
}


class XMLModel extends ModelBase
{
  public function fillData()
  {

    ob_start();
    ?>
    <?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
    <rows>
      <row id="1" name="name1" mailAddress="hoge@example.com" />
      <row id="2" name="name2" mailAddress="fizz@example.com" />
      <row id="3" name="name3" mailAddress="buzz@example.com" />
    </rows>
<?php
    foreach (simplexml_load_string(ob_get_clean())->row  as $row) {
      $obj = new stdClass();
      foreach ($row->attributes() as $key => $value) {
        $obj->key = (string) $value;
      }
      $this->rows[$obj->id] = $obj;
    }
  }
}


// foreach (array("ModelFactoryA", "ModelFactoryB") as $factoryName) {
//   $model = ModelFactoryBase::getInstance($factoryName);
//   foreach (array("XML", "CSV") as $modelName) {
//     var_dump($model);
//     echo  "<<" . $modelName . "の処理 >> <br>";
//     var_dump($model->find(1));
//     $model->delete(1);
//     $model->save((object) array(
//       "id" => 4,
//       "name" => "name4",
//       "mailAddress" => "xyzzy@example.com"
//     ));
//     var_dump($model);
//   }
// }


?>

<a href="client.php">別事例へ</a>
<br>
<a href="/docs/factoryMethod.md">説明へ</a>

```
