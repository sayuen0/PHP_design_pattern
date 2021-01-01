
# Compositeパターン

> *容器と中身を同一視して再帰的構造を作る*

## 概要

再帰。

親と子に同じ振る舞いや属性を持たせる

## 登場人物

- Leaf: 中身。ファイル
- Composite: 複合体。容器を表す。ディレクトリ
- Component: 中身と複合体を同一とみなすためのスーパークラス
- Client: 利用者

## クラス図

![Composite pattern](https://upload.wikimedia.org/wikipedia/commons/5/5a/Composite_UML_class_diagram_%28fixed%29.svg)

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

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Composite/Sample/Entry.java)
[include](../../patterns/dpsrc_2009-10-10/src/Composite/Sample/File.java)
[include](../../patterns/dpsrc_2009-10-10/src/Composite/Sample/Directory.java)
[include](../../patterns/dpsrc_2009-10-10/src/Composite/Sample/FileTreatmentException.java)
[include](../../patterns/dpsrc_2009-10-10/src/Composite/Sample/Main.java)

### PHP

[include](../../patterns/Composite/index.php)
