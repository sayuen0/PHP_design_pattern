# Abstract Factory

> **抽象的な部品を組み合わせて抽象的な製品を作る**

//TODO: [#1](https://github.com/sayuen0/design-pattern-study/issues/1)


## 概要


作り方より先に使い方に着目する


漫画でわかるFactory Methodより

> 作り方より先に使い方に着目する Abstract Factory とは違い、

同じcreateメソッドで呼び出せれば嬉しい。使い方に着目している


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

### PHP

[include](../../patterns/AbstractFactory/php/index.php)


### Java

TODO: #5 #4 埋める
