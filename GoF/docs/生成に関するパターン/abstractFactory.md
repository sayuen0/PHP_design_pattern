# Abstract Factory

> *抽象的な部品を組み合わせて抽象的な製品を作る*


## 概要

## マンガでわかる Abstract Factory

[デザインパターン](https://qiita.com/tags/デザインパターン)[GoF](https://qiita.com/tags/gof)


漫画でわかるFactory Methodより

> 作り方より先に使い方に着目する Abstract Factory とは違い、

同じcreateメソッドで呼び出せれば嬉しい。使い方に着目している

## 活かせそうなシナリオを考えてみる

### HTMLフォーム部品生成

- ログインフォーム
- 新規登録フォーム
- 設定フォーム

いずれもFormインタフェースを実装してcreateから生成されるようにするとか


## ソース

### Java

#### テーブルページかリストページか

[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/factory/Factory.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/factory/Item.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/factory/Link.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/factory/Tray.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/factory/Page.java)

[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/tablefactory/TableFactory.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/tablefactory/TableLink.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/tablefactory/TableTray.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/tablefactory/TablePage.java)

[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/listfactory/ListFactory.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/listfactory/ListLink.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/listfactory/ListTray.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/listfactory/ListPage.java)
[include](../../patterns/dpsrc_2009-10-10/src/AbstractFactory/Sample/Main.java)

### PHP

[include](../../patterns/AbstractFactory/php/index.php)
