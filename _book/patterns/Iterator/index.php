<?php
ini_set("display_errors", "1");



/**
 * 走査と操作を分ける
 * 一つの走査に対して
 * 複数の操作を行えたり
 */


/**
 * 本
 */
class Book
{
  private $name;

  public function __construct($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
}
/**
 * 自前でイテレータのインスタンスを用意
 * イテレータに必要なのは
 * 1. 最初の要素に戻す
 * 2. 現在位置が有効かどうか
 * 3. 現在の要素を返す
 * 4. 次の要素に進める
 * 5. 現在のキーを返す
 */

interface Iteratable
{
  public function rewind();
  public function valid();
  public function current();
  public function next();
  public function key();
}

/**
 * 本棚
 */

class BookShelf
{

  private $bookShelfIterator;

  public function __construct($bookShelfIterator)
  {
    $this->bookShelfIterator = $bookShelfIterator;
  }
  /**
   * 本棚の本をforで数え上げ
   * 一冊ずつfunctionの引数にして実行
   * 
   * @param function $function 
   */

  public function run($function)
  {
    for (
      $this->bookShelfIterator->rewind();
      $current = $this->bookShelfIterator->current();
      $current = $this->bookShelfIterator->next()
    ) {
      $function($current);
    }
  }
}


/**
 * 本棚のイテレータ
 * 
 */


class BookShelfIterator  implements Iteratable
{
  private $bookList = array();
  private $index = 0;

  public function __construct($bookShelf)
  {
    $this->bookList = $bookShelf;
  }

  /**
   * 現在位置より抱えているほんの数の方が大きいときtrue
   */
  public function valid()
  {
    return count($this->bookList) > $this->index;
  }

  /***
   * 初期位置に戻す
   */

  public function rewind()
  {
    $this->index = 0;
  }


  /**
   * 現在位置の本を返す
   * @return Book
   */

  public function current()
  {
    return $this->bookList[$this->index];
  }

  /**
   * 要素を次に進める
   * @return int
   */

  public function next()
  {
    return $this->index++;
  }

  /**
   * 現在のキーを返す
   * @return int
   */
  public function key()
  {
    return $this->index;
  }
}


print "自前イテレータ <br>";
$bookShelf = new BookShelf(new BookShelfIterator(
  array(
    new Book("本1"),
    new Book("本2"),
    new Book("本3"),
  )
));
// PHPって無名関数あったのか...
$bookShelf->run(
  function ($book) {
    print $book->getName() . "<br>";
  }
);


class BookShelfIterator2 extends BookShelfIterator implements Iterator
{
}

print "標準イテレータ <br>";
$bookShelfIterator2 = new BookShelfIterator2(array(
  new Book("本1"),
  new Book("本2"),
  new Book("本3"),

));
// iteratorを実装しているので
// foreachできる
// arrayをiteratorでwrapしている
foreach ($bookShelfIterator2 as $key => $book) {
  print $book->getName() . "<br>";
}
