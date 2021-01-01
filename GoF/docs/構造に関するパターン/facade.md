# facadeパターン

> **シンプルな窓口**

## 概要

複雑な手続き、複数オブジェクトの、それも順番があっていることが必須な呼び出しなどを「よく知っている窓口」であるファサードに任せる。
クライアントからは内部の状態が見えないのが嬉しいところ

## 登場人物

- Facade(正面):とてもシンプルな利用者にわかりやすいインタフェース
- システムを構成するその他大勢のModule:**Facadeのことは意識しない**がFacadeから呼び出されて仕事を行う
- Client: Facadeの利用者

## クラス図

![1920px\-Facade\_UML\_class\_diagram\.svg\.png \(1920×960\)](https://upload.wikimedia.org/wikipedia/commons/thumb/d/d4/Facade_UML_class_diagram.svg/1920px-Facade_UML_class_diagram.svg.png)

## やり方

- Facadeにはクライアントからアクセスできるmainメソッドを置く
- mainのなかで(privateな)インスタンスたちへの呼び出しを行う

## メリット(用途)

- インタフェースを少なくできる
  - 利用者は「まずAをして次にBをして,,,」という手順を覚える必要がなくなる

## 拡張して考える

- 小さいFacadeをModuleとしてみなし、それらを束ねる大きいFacadeを実装して、大きなシステムを実装する **(再帰的にFacadeパターンする)**

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Facade/Sample/Main.java)
[include](../../patterns/dpsrc_2009-10-10/src/Facade/Sample/pagemaker/PageMaker.java)
[include](../../patterns/dpsrc_2009-10-10/src/Facade/Sample/pagemaker/Database.java)
[include](../../patterns/dpsrc_2009-10-10/src/Facade/Sample/pagemaker/HtmlWriter.java)
[include](../../patterns/dpsrc_2009-10-10/src/Facade/Sample/maildata.txt)

### PHP

[include](../../patterns/Facade/index.php)
