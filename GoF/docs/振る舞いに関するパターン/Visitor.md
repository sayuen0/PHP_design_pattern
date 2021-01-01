# Visitorパターン

> **構造を渡り歩きながら仕事をする**

## 概要

データ構造と処理を分離

## 登場人物

- Visitor: ConcreteElementごと訪問するvisitメソッドを宣言するインタフェース
- ConcreteVisitor: Visitorを実装
- Element:Visitorの訪問先インタフェース
  - Visitorを引数にもち受け入れるacceptメソッドを持つ
- ConcreteElement:Elementを実装
- ObjectStructure: Elementの集合

## クラス図

![VisitorClassDiagram\.png \(523×393\)](https://upload.wikimedia.org/wikipedia/commons/8/8d/VisitorClassDiagram.png)

## やり方

## メリット(用途)

- 部品としての独立性が高まる
  - 各ConcreteElementに処理を持たせる必要がない
- 全要素に対する新しい処理の追加が簡単
  - ConcreteVisitorを追加すればいいだけ


## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/Element.java)
[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/ListVisitor.java)
[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/Visitor.java)
[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/Directory.java)
[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/File.java)
[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/Main.java)
[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/FileTreatmentException.java)
[include](../../patterns/dpsrc_2009-10-10/src/Visitor/Sample/Entry.java)

### PHP

[include](../../patterns/Visitor/index.php)
