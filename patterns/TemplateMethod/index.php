<?php
function say($i)
{
  print "$i \n";
}

// template method 


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

  // 入力値を検証してエラーページに遷移するか
  // 実処理を行うかを処理
  // この部分がテンプレートメソッド
  // doActionとdomainを呼び出すという手順はまとめている

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

<a href="/design_patterns/docs/templatemethod.md">説明へ</a>
