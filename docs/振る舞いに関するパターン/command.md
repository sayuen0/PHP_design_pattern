# Commandパターン

> **命令をクラスにする**


## 概要

命令の集まりを履歴として保存して、取り消したりやり直したりできる



## 登場人物

- Command: インタフェース
- ConcreteCommand
- Reciever: Commandの命令実行対象
- Client: ConcreteCommandを生成して、Recieverを割り当てる
- Invoker: 命令実行開始役

## クラス図

![Command\_Design\_Pattern\_Class\_Diagram\.png \(557×353\)](https://upload.wikimedia.org/wikipedia/commons/8/8e/Command_Design_Pattern_Class_Diagram.png)

## やり方


## メリット(用途)

## 関連
  
- Composite: マクロコマンド(コマンドの集まり)も、コマンドである
- Memento: コマンド履歴の保存に使える
- Prototype: コマンドの複製に使える


## ソース

### PHP

```php
function main()
{
  $sh = new ShellScript();
  $fs = new FileSystem("./tmp/sample/");
  $sh->add(new MakeDirectoryCommand($fs));

  var_dump($sh->run());
  var_dump($sh->undo());
  var_dump($sh->next());

  // var_dump($sh->undo());
  // var_dump($sh->undo());
}

main();



/**
 * Reciever
 */
class FileSystem
{
  private $path;

  public function __construct($path)
  {
    $this->path = $path;
  }

  public function changeDirectory()
  {
    return "cd $this->path";
  }

  public function makeDirectory()
  {
    return exec("mkdir -p $this->path");
  }
  public function removeDirectory()
  {
    return exec("rm -r  $this->path");
  }

  public function createFile()
  {
    return "touch $this->path";
  }

  public function removeFile()
  {
    return "rm $this->path";
  }
}

/**
 *  コマンドインタフェース
 * 実行と取り消し
 */
interface ShellCommand
{
  /**
   * 実行
   */
  public function execute();

/**
 * 取り消し
 */
  public function undo();
}

class MakeDirectoryCommand implements ShellCommand
{
  private $fileSystem;

  public function __construct($fileSystem)
  {
    $this->fileSystem = $fileSystem;
  }

  public function execute()
  {
    return $this->fileSystem->makeDirectory();
  }
  public function undo()
  {
    return $this->fileSystem->removeDirectory();
  }
}


class RemoveDirectoryCommand implements ShellCommand
{
  private $fileSystem;

  public function __construct($fileSystem)
  {
    $this->fileSystem = $fileSystem;
  }

  public function execute()
  {
    return $this->fileSystem->removeDirectory();
  }
  public function undo()
  {
    return $this->fileSystem->makeDirectory();
  }
}


/**
 * シェルスクリプト
 * コマンドの集まり
 */
class ShellScript
{
  /**
   * コマンドたち
   */
  public $commands  = array();
  /**
   * 行番号
  */
  private $position  = 0;

// 追加
  public function add($cmd)
  {
    $this->commands[] = $cmd;
  }

/**
 * 次の行を実行
 * @param times 実行数
 */
  public function next($times = 1)
  {
    $result = array();
    for ($i = 0; $i < $times; $i++) {
      $result[] = $this->commands[$this->position++]->execute();
    }
    return $result;
  }

/**
 * 取り消し
 */
  public function undo($times = 1)
  {
    $result = array();
    for ($i = 0; $i < $times; $i++) {
      $result[] = $this->commands[--$this->position]->undo();
    }
    return $result;
  }

/**
 * 全部実行
 */
  public function run()
  {
    return $this->next(count($this->commands) - $this->position);
  }
}
```


