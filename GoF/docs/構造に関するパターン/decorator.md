
# Decoratorパターン

> **飾り枠と中身の同一視**

## 概要

いわゆるラッパークラス

本質部分をプロパティに持って、委譲すれば良し

## 登場人物

- Component: 機能追加のコアとしてのインタフェース。デコレーション前のスポンジケーキ
- ConcreteComponent: 具体的なスポンジケーキ
- Decorator: 自分が飾っている対象(Component)をプロパティに持ち、かつComponentを実装している
- ConcreteDecorator: Decoratorを実装

## クラス図

![480px\-Decorator\_UML\_class\_diagram\.svg\.png \(480×380\)](https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Decorator_UML_class_diagram.svg/480px-Decorator_UML_class_diagram.svg.png)

## やり方

- DecoratorはComponentを実装し、さらにComponentをプロパティとしてもつ
  - こうすることでConcreteDecoratorはConcreteComponentの機能を全て使うことができるようになる

## メリット

- 中身を変えずに機能追加ができる
  - DecoratorもComponentも同一インタフェースを持つが、包めば包むほど機能が追加される
  - **その際包まれるComponentの修正は必要なし**
- 単純な品揃えでも多様な機能追加ができる
  - アイスクリームのトッピングを、バニラ、チョコ、ストロベリー、キウイ、組み合わせとして

## 関連

### Adapter

目的が違う

- Adapterは「右と左の端子の形式が違うから、それらを接続するインタフェースが必要」という意図
- Decoratorは「左右の端子があっているところに、それと同じ形の端子を付けた装置をを割り込ませる」
  - 「右も左もUSBだけど、平文じゃなく暗号化できるコードをかましますよ」

## Javaソースに見る

Java.ioパッケージクラスはDecoratorパターンを採用している

これにより極めて多様な機能追加が実現できる

```java
//普通にファイルを読み込む
Reader reader = new FileReader(filename);
//バッファリングして読み込む
Reader reader = new BufferReader(new FileReader(filename));
//行番号を指定し、バッファリングして読み込む
Reader reader = new LineNumberReader(new BufferReader(new FileReader(filename)));
//行番号は管理するけど、バッファリングしない
Reader reader = new LineNumberReader(new FileReader(filename));
//行番号を管理しバッファリングするが、ファイルからでなくネットワークから読み込む
java.net.Socket socket = new Socket(hostname,portNumber);
Reader reader = new LineNumberReader(new BufferReader(new InputStreamReader(socket.getInputStream())));
```

## ソース

### Java

#### アイスクリームの例

[include](../../patterns/Decorator/java/IceCream.java)
[include](../../patterns/Decorator/java/StrawBerryIceCream.java)
[include](../../patterns/Decorator/java/VanillaIceCream.java)
[include](../../patterns/Decorator/java/DoubleIceCream.java)
[include](../../patterns/Decorator/java/TripleIceCream.java)
[include](../../patterns/Decorator/java/ChocoTippedIceCream.java)
[include](../../patterns/Decorator/java/WaffleCornIceCream.java)
[include](../../patterns/Decorator/java/Main.java)

#### ディスプレイの例

[include](../../patterns/dpsrc_2009-10-10/src/Decorator/Sample/Border.java)
[include](../../patterns/dpsrc_2009-10-10/src/Decorator/Sample/Display.java)
[include](../../patterns/dpsrc_2009-10-10/src/Decorator/Sample/SideBorder.java)
[include](../../patterns/dpsrc_2009-10-10/src/Decorator/Sample/FullBorder.java)
[include](../../patterns/dpsrc_2009-10-10/src/Decorator/Sample/StringDisplay.java)
[include](../../patterns/dpsrc_2009-10-10/src/Decorator/Sample/Main.java)

### PHP

[include](../../patterns/Decorator/php/index.php)
