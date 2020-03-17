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

