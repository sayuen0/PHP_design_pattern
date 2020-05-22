
# Compositeパターン

> 容器と中身を同一視して再帰的構造を作る


再帰。

親と子に同じ振る舞いや属性を持たせる

## やり方

- 親にも子にも同一の抽象クラスを定義させる
- 親が子(または子の一覧)をプロパティに持てば良い

### 注意点

- データ構造が必ず木構造になること。
- 循環したら再帰により無限ループが発生する



## ユースケース

### ファイルシステム

ファイルとディレクトリ(まとめてディレクトリエントリという)

### HTMLの構文解析



# ソース

```php
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
```
