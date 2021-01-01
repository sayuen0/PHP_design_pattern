# Flyweightパターン

> **同じものを共有して無駄をなくす**

## 概要

- 等価なオブジェクトは共有したら軽量化できるよねって話

## 登場人物

- ファクトリ: 生成するやつ
- フライウェイト: 軽くしたいやつ

## やり方

1. ファクトリはフライウェイトオブジェクトをメンバーに持つ
2. ファクトリ自身はpublicでstaticな、1度目の呼び出しだけ「生成」し2度目以降の呼び出しはすでに生成したやつを返すgetInstanceメソッドを持つ
3. ファクトリからのフライウェイトは、既にあれば既存のものを返し、なかったら一度だけ生成して登録して返す

## クラス図

![pattern](https://upload.wikimedia.org/wikipedia/commons/b/be/Flyweight_UML_class_diagram.svg)

## メリット

- メモリ節約：これに尽きる
- 時間節約：インスタンス生成に時間のかかるオブジェクトなら

## 注意点

### intrinsic(本来備わっている情報)かextrinsic(外からやってきた情報)か

Flyweightに変更を加えると当然だけどアプリケーション内のFlyweightインスタンス全てに変更が共有される。

- イントリンジック: 場所や状況に依存しない情報。共有して良いのでFlyweightに組み込んで良い
- エクストリンジック: 場所や状況に応じ変わる情報。共有されるとおかしいので、組み込んではいけない

## ソース

### Java

big number text たち

[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big0.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big1.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big2.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big3.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big4.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big5.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big6.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big7.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big9.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big8.txt)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/big-.txt)

[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/BigString.java)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/BigCharFactory.java)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/Main.java)
[include](../../patterns/dpsrc_2009-10-10/src/Flyweight/Sample/BigChar.java)

### PHP

[include](../../patterns/Flyweight/index.php)
