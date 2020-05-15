
# template method

## 概念

振る舞いを歯抜けで抽象させて、
それをサブクラスが具体で補う

これに関しては漫画があまりにわかりやすいのでそれを半睡

新しくツイッターボットを作ることを考える。「ドロリッチなう」とツイートしたユーザにPRリプを送る

昔、ファボ10000超のツイートをした人に引用許可願いのリプを送るボットを作成していた。これをコピペするのか

しかし、ツイッターAPIの仕様が変われば、コピペした2者の修正が必要になる

そこで、全体の共通化はできているが内部の処理が歯抜けになった抽象メソッドを用意する

それを継承した具象が歯抜けを埋めて、個々の機能に対応させる。

```
TwitterBot抽象

- トークンの管理
- フェッチ
- (判別ルール)
- HTTP通信
- (送信内容決定)
- エラー処理
```

以上の部分を

```
PRボット具象
- 「ドロリッチなう」と呟いた人
- PRリプ
```

```
引用許可願い具象
- 10000ファボのツイートをした人
- 引用願い
```

で穴埋めして運用する



## やり方

1. 実装は決めないが呼び出し順は決めたメソッドを持つ抽象クラスを作成する
2. 実装内容を決めない抽象メソッドを配置する
   - サブクラスからしか呼べないように可視性を**protected**にしておくとなお良し
3. 抽象クラス内に**抽象メソッドの呼び出し順を定義した具体メソッド**を配置する。これがテンプレートメソッド
   - Javaなら、これをfinalでオーバーライド不可にして置くとなお良し
4. 継承し、抽象メソッドをオーバーライド
5. クライアントからはテンプレートメソッドを呼び出す


## メリット(用途)

**抽象クラスのテンプレートメソッドに誤りが見つかったら、(具象には手をつけず)それだけ直せば済む。**
もしコピペ実装していたら修正クラスファイルが増える。



## 関連パターン

### Factory Method

Template Methodをインスタンス生成に使うとFactory Method。

### Strategy

- Template Method : **継承**によりプログラムの動作を変更
  - スーパクラスで大枠の振る舞いを決めてサブクラスで実装
- Strategy: **委譲**によりプログラムの動作を変更
  - アルゴリズム全体をごっそり切り替える




# ソース

```php
<?php
function say($i)
{
  print "$i \n";
}

// template method 
/**
 * 処理の流れの法則性と具体的な実装を分けることで汎用性を持たせる
 * 
 */


abstract class AbstractAction
{
  private $request = null;
  private $session = array();
  private $assigned  = array();
  private $errors = array();
  private $errorPageName = "error.view";
  private $modelFactory = null;

  public function __construct()
  {
  }
  // 入力値の検証
  abstract function validate();

  // 実処理
  abstract function doMain();

  /**
   *
   * 入力値を検証してエラーページに遷移するか
   * 実処理を行うかを処理
   * この部分がテンプレートメソッド
   * validateして、その結果から
   * エラーを投げるかdomainを呼び出すという手順はまとめている
   * @return void
   */

  public function doAction()
  {
    if (!$this->validate()) return $this->errorPageName;
    return $this->doMain();
  }

  public function assign($key, $val)
  {
    $this->assigned[$key] = $val;
  }

  public function getAssigned($key)
  {
    return $this->assigned[$key];
  }

  public function getRequestValue($key)
  {
    return @$this->request[$key];
  }

  public function setSessionValue($key, $val)
  {
    $this->session[$key] = $val;
  }

  public function getSessionValue($key)
  {
    return @$this->session[$key];
  }

  public function setRequest($request)
  {
    if (!is_array($request)) throw new Exception("配列じゃないじゃないか", 1);
    if ($this->request) {
      throw new Exception("すでに設定されてるじゃないか");
    }
    $this->request = $request;
  }
  public function setSession($session)
  {
    if (!is_array($session)) throw new Exception("配列じゃないじゃないか", 1);
    if ($this->session) {
      throw new Exception("すでに設定されてるじゃないか");
    }
    $this->session = $session;
  }

  public function setError($key, $val)
  {
    $this->errors[$key] = $val;
  }

  public function getError($key)
  {
    return $this->errors[$key];
  }

  public function hasError()
  {
    return count($this->errors);
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function getModel($key)
  {
    return $this->modelFactory->create($key);
  }

  public function setModelFactory($obj)
  {
    if (!$obj instanceof ModelFactory) {
      throw new Exception("こんなオブジェクト無理だ");
    }
    $this->modelFactory = $obj;
  }
}


// /user/index 実装クラス

class UserIndexAction extends AbstractAction
{
  public function __construct()
  {
  }
  public function validate()
  {
    return true;
  }
  public function doMain()
  {
    return "index.view";
  }
}


// /user/entry

class UserEntryAction extends AbstractAction
{
  protected $errorPageName = "redirect: /UserForm";
  public function __construct()
  {
  }
  public function validate()
  {
    if (!$this->getRequestValue("name")) {
      $this->setError("name", "not_required");
    }
    if (!$this->getRequestValue("mail_address")) {
      $this->setError("mail_address", "not_required");
    } elseif (!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $this->getRequestValue("mail_address"))) {
      $this->setError("mail_address", "invalid_format");
    }
    return !$this->hasError();
  }
  public function doMain()
  {
    $user = $this->getModel("User");
    $this->name = $this->getRequestValue("name");
    $this->mail_address = $this->getRequestValue("mail_address");
    $user->save();
    $this->assign("User", $user);
    return "redirect: /UserFinished";
  }
}


class ModelFactory
{
  public function __construct()
  {
  }

  public function create($class)
  {
    return new $class;
  }
}


class User
{
  private $values = array();
  public function __construct()
  {
  }

  public function __set($key, $val)
  {
    $this->values[$key] = $val;
  }

  public function __get($key)
  {
    return $this->values["key"];
  }

  public function save()
  {
    return true;
  }
}



// indexが普通に走る

$index = new UserIndexAction();
$index->setModelFactory(new ModelFactory());
say($index->validate() == true ? "OK" : "NG");
say($index->doMain() == "index.view" ? "OK" : "NG");

// validateに引っかからないのでdoMainが実行される
say($index->doAction() == "index.view" ? "OK" : "NG");

// entryがvalidateで引っかかるテスト
// nameとemailが未入力の状態でPOSTされる

$entry  = new UserEntryAction();
$entry->setModelFactory(new ModelFactory());
say($entry->validate() == false ? "OK" : "NG");
say($entry->getError("name") == "not_required" ? "OK" : "NG");
say($entry->getError("mail_address") == "not_required" ? "OK" : "NG");



// entryがvalidateで引っかかるテスト
// email未入力
$entry = new UserEntryAction();
$entry->setModelFactory(new ModelFactory());
$entry->setRequest(array("name" => "hoge"));
say($entry->validate() == false ? "OK" : "NG");
say($entry->getError("mail_address") == "not_required" ? "OK" : "NG");



// name emailどちらもある format error
$entry = new UserEntryAction();
$entry->setModelFactory(new ModelFactory());
$entry->setRequest(array("name" => "hoge", "mail_address" => "hoge"));
say($entry->validate() == false ? "OK" : "NG");
say($entry->getError("mail_address") == "invalid_format" ? "OK" : "NG");

// name email 正しくぽすと


$entry = new UserEntryAction();
$entry->setModelFactory(new ModelFactory());
$entry->setRequest(array("name" => "hoge", "mail_address" => "sayuen0@gmail.com"));
say($entry->validate() == true ? "OK" : "NG");
say($entry->doAction() == "redirect: /UserFinished" ? "OK" : "NG");


$entry->assign("User", new User());
$user = $entry->getAssigned("User");
say($user instanceof User ? "OK" : "NG");
say($user->name == "hoge" ? "OK" : "NG");
say($user->mail_address == "sayuen0@gmail.com" ? "OK" : "NG");

echo $user->name;



// webで実行する際は
// $class = new class();
// $class->setRequest($_REQUEST);
// $class->setSession($_SESSION);
// $view = $class->doAction()
// $_SESSION = $this->getSession();

// 大事なのは、doActionとすればvalidateしてdomainが呼び出されることが共通化されている点。

?>

<a href="/docs/templateMethod.md">説明へ</a>

```
