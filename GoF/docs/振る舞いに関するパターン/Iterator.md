# Iteratorパターン

## 概要

走査と操作を分ける
一つの走査に対して
複数の操作を行えたり

## 意図

Iterableな構造はたくさんある。IOとかMAPとかリンクリストとか。それらに対して

```php
for($i = 0; $i < $length; $i ++ ){
  ...
}
```

必ずしもこのように走査できるわけではない。

そこで「関心の分離」。反復可能という概念だけ抽出して、ロジックは個々のデータ構造にまかせる。

## クラス図

![Iterator UML class diagram \- Iterator パターン \- Wikipedia](https://upload.wikimedia.org/wikipedia/commons/1/13/Iterator_UML_class_diagram.svg)

## 留意点

- モダン言語なら標準で搭載されていることが多い機能なので、自分で書くことを目的にする必要はない。
- あくまで名前を持つ概念の意味を理解して共有することが目的。
- それはそれとしてIteratorは偉大なのでよく味わうべき

## やり方

イテレータには以下を実装する

1. 最初の要素に戻す
2. 現在位置が有効かどうか
3. 現在の要素を返す
4. 次の要素に進める
5. 現在のキーを返す

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Iterator/Sample/BookShelfIterator.java)
[include](../../patterns/dpsrc_2009-10-10/src/Iterator/Sample/Aggregate.java)
[include](../../patterns/dpsrc_2009-10-10/src/Iterator/Sample/Iterator.java)
[include](../../patterns/dpsrc_2009-10-10/src/Iterator/Sample/BookShelf.java)
[include](../../patterns/dpsrc_2009-10-10/src/Iterator/Sample/Book.java)
[include](../../patterns/dpsrc_2009-10-10/src/Iterator/Sample/Main.java)

### PHP

[include](../../patterns/Iterator/index.php)
