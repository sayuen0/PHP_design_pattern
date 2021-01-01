# Builderパターン

何らかの**構造**を持った成果物を組み立てる際

## 概要

人間がHTMLで文章を書くとき、
HTMLのシンタックスをいちいち組み立てるのではなく、コンテンツ(とタグの種類)を与えたら、正しいシンタックスのタグを自動生成してほしいという考え。
そのタグの自動生成はBuilderクラスにやらせる。

**人間はBuilderの具体的な挙動を知らなくても良い。**

## 登場人物

- Builder: インスタンス生成のためのAPIを定める抽象クラス
- ConcreteBuilder: BuilderのAPIを実装し、具体的なものを作る
- Director: Builderインタフェースを使ってインスタンスを生成する
  - **ConcreteBuilderの種類に関係なく使えるように、Builderメソッドのみ呼ぶ**
- Client: 利用者。Main

## やり方

1. Builderにインスタンス生成のための抽象メソッドを定義する
2. DirectorはBuilder型のプロパティを持ち、Builder型のメソッドを呼ぶ
3. MainはConcreteBuilderとDirectorを生成し、Directorに「作れ」と一言言う。
   1. DirectorはBuilderメソッドを通じてConcreteBuilderから成果物を作る

## クラス図

![pattern](https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Builder_UML_class_diagram.svg/1920px-Builder_UML_class_diagram.svg.png)

## メリット(用途)

「交換可能性」: 入れ替えられるからこそ部品としての信頼性が高くなる

- ClientはBuilderのメソッドは**知らない**。ClientがDirectorにお願いするとDirectorのなかでむにゃむにゃ仕事が進んでいい感じの成果物ができている
- DirectorはConcreteBuilderの実装を**知らない**。知らないのでHTMLBuilderだろうがMarkdownBuilderだろうが問題なく動かせる。
- 近い将来扱う書式が増えそうなとき有効なパターン

## 応用例

### CSV, XML形式を作り分ける

- ディレクタは属性と値だけ指定する
- ビルダがデリミターやタグなどに従って適切に配置する

### SQLを組み立てる

- SELECT, UPDATE, INSERTなど組み立てたいクエリの見出し
- テーブル名
- 属性
- 条件

などを指定すると、ビルダが勝手にSQLを組み立ててくれる

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Builder/Sample/TextBuilder.java)
[include](../../patterns/dpsrc_2009-10-10/src/Builder/Sample/Builder.java)
[include](../../patterns/dpsrc_2009-10-10/src/Builder/Sample/HTMLBuilder.java)
[include](../../patterns/dpsrc_2009-10-10/src/Builder/Sample/Director.java)
[include](../../patterns/dpsrc_2009-10-10/src/Builder/Sample/Main.java)

### PHP

[include](../../patterns/Builder/index.php)
