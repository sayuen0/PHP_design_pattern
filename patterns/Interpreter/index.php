<?php
ini_set("display_errors", 1);
/**
 * DSLを定義して複雑度を減らす
 * DSL: ドメイン固有言語 domain-specific language
 * 字句解析をして式と値に同じ「値」を返させ
 * ブロックは式の集合、式は式の集合
 * つまりComposite
 */


/**
 * フリーワード検索の文法を簡易にしてSQLにして変換する仕組み
 */

class QueryParser
{
  protected $args = array();
  protected $query  = null;



  public function __construct($q)
  {
    $this->query = $q;
    $this->parse();
  }

  public function setArgs($args)
  {
    $this->args = $args;
  }

  public function parse($query = null)
  {
    if (!$query)  $query = $this->query;
    $quote = "";
    $buf = "";
    $length = mb_strlen($query, "UTF8");
    // 引数で渡された文字列の長さ分ループ
    for ($i = 0; $i < $length; $i++) {
      // i番目の文字
      $char = mb_substr($query, $i, 1, "UTF8");
      // $quoteに["] or [']が代入されているとき
      if ($quote) {
        // $charが["] or [']ならその文字を取り出す
        // "hoge"なら 「hoge」を取り出す
        if ($quote == $char) {
          $this->args[] = $buf;
          $quote = null;
          $buf = null;
        }
        // 現在の文字がエスケープ文字の場合次の文字をbufに足す
        elseif ($char == "\\") {
          $buf  .= mb_substr($query, ++$i, 1, "UTF8");
          // 現在の文字をbufに足す
        } else {
          $buf .= $char;
        }
      }
      // 現在の文字が["] or [']の時
      elseif ($char == "'" || $char == '"') {
        // これまでbufに追加した文字列をargsに代入
        if ($buf) {
          $this->args[] = $buf;
        }
        // クオートの開始判定変数用に代入
        $quote = $char;
        // $bufをクリア
        $buf = null;
      }
      // 現在の文字が空白の場合
      elseif ($char == "") {
        if ($buf) {
          // これまでにbufに追加した文字列を
          // argsに代入してbufをクリア
          $this->args[]   = $buf;
          $buf = null;
        }
      }
      // 特殊文字ではない場合は普通にbufに現在の文字を追加
      else {
        $buf .= $char;
      }
    }
    // ループを抜けたとき、これまでbufに追加された文字列を配列に追加
    if ($buf)  $this->args[] = $buf;
    return  $this->args;
  }
  public function getArgs()
  {
    return $this->args;
  }

  /**
   * 分解した単語からSQLのクエリを生成
   */

  public function createQuery($idx = 0)
  {
    $group  = new QueryGroup();
    for ($i = $idx; $i < count($this->args); $i++) {
      // [(]の場合再帰的にcreateQueryを読んでQueryGroupを作る
      if ($this->args[$i] == "(") {
        list($obj, $i) = $this->createQuery($i + 1);
        $group->set($obj);
        $i++;
      } elseif ($this->args[$i] == "&&") {
        $group->set(new QueryAnd($this->args[$i]));
      } elseif ($this->args[$i] == "||") {
        $group->set(new QueryOr($this->args[$i]));
      } elseif ($this->args[$i] == ")") {
        break;
      } else {
        $group->set(new QueryOperand($this->args[$i]));
      }
      if ($group->isFull()) {
        break;
      }
      if ($idx) {
        return array($group, $i);
      } else {
        return $group;
      }
    }
  }
}

interface IQuery
{
  public function toQuery();
}

class QueryAnd  implements IQuery
{


  public function __construct($e)
  {
    $this->_Element = $e;
  }
  public function toQuery()
  {
    return "AND";
  }
}

class QueryOr  implements IQuery
{

  public function __construct($e)
  {
    $this->_Element = $e;
  }
  public function toQuery()
  {
    return "OR";
  }
}

/**
 * [idx like "%hoge%"]のQueryを生成
 */

class QueryOperand  implements IQuery
{
  private $_Element;

  public function __construct($e)
  {
    $this->_Element = $e;
  }
  public function toQuery()
  {
    return "idx LIKE %" . $this->escape() . "%";
  }

  public function escape()
  {
    return str_replace("'", "''", $this->_Element);
  }
}


/**
 * [A 演算子 B]のグループ
 * 
 */


class QueryGroup  implements IQuery
{
  protected $left = null;
  protected $right = null;
  protected $operator = null;
  public function set($obj)
  {
    // 左、演算子、右の順で代入
    if (!$this->left) {
      $this->left = $obj;
    } elseif (!$this->operator) {
      $this->operator = $obj;
    } elseif (!$this->right) {
      $this->right = $obj;
    }
  }
  public function isFull()
  {
    return $this->left && $this->operator && $this->right;
  }

  public function toQuery()
  {
    $result = "";
    if ($this->left) {
      $result .= $this->left->toQuery();
    }
    if ($this->operator) {
      $result .= $this->operator->toQuery();
    }
    if ($this->right) {
      $result .= $this->right->toQuery();
    }
    if ($result) {
      return "( " . trim($result) . ")";
    } else {
      return "";
    }
  }
}

$obj = new QueryParser(
  '("hoge" && "doya") || ("fuga" && "pi\\"yo")'
);
// 単語の分解

$args = $obj->getArgs();
var_dump($args);

// sql生成

print $obj->createQuery()->toQuery();
